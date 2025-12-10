import { exec } from 'node:child_process';
import { promisify } from 'node:util';
import { writeFile } from 'node:fs/promises';
import * as path from 'node:path';

const execAsync = promisify(exec);

// --- Configuration ---
const STATE_FILENAME = './activity-state.json';
const STATE_FILE_PATH = path.resolve(STATE_FILENAME);
const SEARCH_LIMIT = 150;
const GH_HOST_ENV = process.argv[2] || 'github.com';
const SHOW_DAYS_AGO = true;

await main();

async function main(): Promise<void> {
  console.error(
    `🔍 Scanning ${GH_HOST_ENV} for activity (Limit: ${SEARCH_LIMIT})...`
  );

  const currentUser = await getCurrentUser();
  const history = await loadHistory();

  // 1. "Same Day" Logic
  // We reset today's entry so we can re-run the script multiple times a day
  const today = new Date().toISOString().split('T')[0]!;
  if (history.length > 0 && history[history.length - 1]!.date === today) {
    console.error(
      `   Found existing run for today (${today}). Refreshing data...`
    );
    history.pop();
  }

  // 2. Build Set of Known Keys
  const seenKeys = new Set<string>();
  for (const run of history) {
    for (const key of run.items) {
      seenKeys.add(key);
    }
  }

  // 3. Fetch Data
  const items = await fetchSearchResults(currentUser);

  if (items.length === 0) {
    console.log('No activity found.');
    return;
  }

  // 4. Identify New vs Updated Items
  const newItems: GithubItem[] = [];
  const potentialUpdates: { item: GithubItem; index: number }[] = [];
  let lastNewItemIndex = -1;

  items.forEach((item, index) => {
    const { org, repo } = parseRepoInfo(item);
    const key = createKey(org, repo, item.number);

    if (!seenKeys.has(key)) {
      newItems.push(item);
      lastNewItemIndex = index;
    } else {
      potentialUpdates.push({ item, index });
    }
  });

  // Filter updates: Only keep seen items that appeared *before* the last new item.
  // This implies they have been active recently (since they sort higher than a new item).
  const updatedItems = potentialUpdates
    .filter((p) => p.index < lastNewItemIndex)
    .map((p) => p.item);

  // 5. Truncation Warning
  if (items.length >= SEARCH_LIMIT) {
    const oldestFetched = items[items.length - 1]!;
    const { org, repo } = parseRepoInfo(oldestFetched);
    const oldestKey = createKey(org, repo, oldestFetched.number);

    if (!seenKeys.has(oldestKey)) {
      console.warn(`\n⚠️  WARNING: Reached limit of ${SEARCH_LIMIT} items.`);
      console.warn(
        `   The oldest item fetched (${oldestFetched.title}) is still 'new'.`
      );
      console.warn(
        `   You may have missed activity. Run with a higher limit manually.\n`
      );
    }
  }

  if (newItems.length === 0 && updatedItems.length === 0) {
    console.log('No new or updated activity found since last run.');
    return;
  }

  // 6. Output
  printReport(newItems, updatedItems, currentUser);

  // 7. Save History (Only new items are added to state)
  const runRecord: RunRecord = {
    date: today,
    items: newItems.map((item) => {
      const { org, repo } = parseRepoInfo(item);
      return createKey(org, repo, item.number);
    }),
  };

  history.push(runRecord);
  await saveHistory(history);
}

async function fetchSearchResults(currentUser: string): Promise<GithubItem[]> {
  const fields = 'number,title,url,repository,author,assignees,createdAt,state';
  const cmd = `gh search issues --involves ${currentUser} --sort updated --include-prs --limit  ${SEARCH_LIMIT} --json ${fields}`;

  try {
    const { stdout } = await execAsync(cmd, {
      env: { ...process.env, GH_HOST: GH_HOST_ENV },
    });
    return JSON.parse(stdout) as GithubItem[];
  } catch (err) {
    console.error(`Failed to fetch search results`, err);
    return [];
  }
}

function printReport(
  newItems: GithubItem[],
  updatedItems: GithubItem[],
  currentUser: string
): void {
  const repoMap = new Map<string, RepoGroup>();

  // Helper to process items into groups
  const processItem = (
    item: GithubItem,
    category: 'direct' | 'participated' | 'updated'
  ) => {
    const fullName = item.repository.nameWithOwner;
    if (!repoMap.has(fullName)) {
      repoMap.set(fullName, {
        name: fullName,
        direct: [],
        participated: [],
        updated: [],
      });
    }
    const group = repoMap.get(fullName)!;

    if (category === 'updated') {
      group.updated.push(item);
      return;
    }

    const isAuthor = item.author.login === currentUser;
    const isAssignee = item.assignees.some((a) => a.login === currentUser);

    if (isAuthor || isAssignee) {
      group.direct.push(item);
    } else {
      group.participated.push(item);
    }
  };

  // Process lists
  newItems.forEach((item) => processItem(item, 'direct')); // 'direct' logic handles splitting inside
  updatedItems.forEach((item) => processItem(item, 'updated'));

  // Output Loop
  console.log(`\n# Activity Report (${new Date().toLocaleDateString()})\n`);

  for (const group of repoMap.values()) {
    console.log(`**${group.name}**`);

    if (group.direct.length > 0) {
      console.log(`- **Directly Worked On**`);
      group.direct.forEach((item) => printItem(item, currentUser));
    }

    if (group.participated.length > 0) {
      console.log(`- **Participated In**`);
      group.participated.forEach((item) => printItem(item, currentUser));
    }

    if (group.updated.length > 0) {
      console.log(`- **Previously Reported (Updated Recently)**`);
      group.updated.forEach((item) => printItem(item, currentUser));
    }
    console.log('');
  }
}

function printItem(item: GithubItem, currentUser: string): void {
  const type = item.url.includes('/pull/') ? 'PR' : 'Issue';

  let daysSuffix = '';
  if (SHOW_DAYS_AGO) {
    const date = new Date(item.createdAt);
    const diffTime = Math.abs(Date.now() - date.getTime());
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    daysSuffix = ` (${diffDays} days ago)`;
  }

  let authorSuffix = '';
  if (item.author.login !== currentUser) {
    authorSuffix = ` (by @${item.author.login})`;
  }

  // Format: - [PR](url) Title (by @user) (x days ago)
  console.log(
    `  - [${type}](${item.url}) ${item.title}${authorSuffix}${daysSuffix}`
  );
}

async function getCurrentUser(): Promise<string> {
  try {
    const { stdout } = await execAsync(`gh api user --jq ".login"`, {
      env: { ...process.env, GH_HOST: GH_HOST_ENV },
    });
    return stdout.trim();
  } catch (e) {
    console.error('Could not get current user. Are you logged in?');
    process.exit(1);
  }
}

function parseRepoInfo(item: GithubItem): { org: string; repo: string } {
  const parts = item.repository.nameWithOwner.split('/');
  return {
    org: parts[0]!,
    repo: parts[1]!,
  };
}

function createKey(org: string, repo: string, number: number): string {
  return `${org}/${repo}#${number}`;
}

async function loadHistory(): Promise<RunRecord[]> {
  try {
    // Using import for JSON reading
    const module = await import(STATE_FILENAME, { with: { type: 'json' } });
    const data = module.default;
    return Array.isArray(data) ? (data as RunRecord[]) : [];
  } catch (e) {
    return [];
  }
}

async function saveHistory(history: RunRecord[]): Promise<void> {
  await writeFile(STATE_FILE_PATH, JSON.stringify(history, null, 2));
}

// --- Interfaces ---

interface GithubItem {
  number: number;
  title: string;
  url: string;
  state: string;
  createdAt: string;
  author: { login: string };
  assignees: { login: string }[];
  repository: {
    name: string;
    nameWithOwner: string;
  };
}

interface RunRecord {
  date: string;
  items: string[]; // Compact format: "org/repo#number"
}

interface RepoGroup {
  name: string;
  direct: GithubItem[];
  participated: GithubItem[];
  updated: GithubItem[];
}
