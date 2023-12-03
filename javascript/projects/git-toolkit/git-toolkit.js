import fs from 'node:fs';
import { execSync } from 'node:child_process';
import { join } from 'node:path';

/**
 * List of repositories that are actively committed to, and thus should have a
 * "git fetch" run on
 */
const activeRepositories = [
  '/Users/maxpatiiuk/site/git/code-share',
  '/Users/maxpatiiuk/site/git/custom-new-tab-page',
  '/Users/maxpatiiuk/site/git/dotfiles',
  '/Users/maxpatiiuk/site/git/mambo.zzz.com.ua',
  '/Users/maxpatiiuk/site/git/pre-commit',
  '/Users/maxpatiiuk/site/git/private-dotfiles',
  '/Users/maxpatiiuk/site/git/specify-tools',
  //
  '/Users/maxpatiiuk/site/javascript/calendar-plus',
  '/Users/maxpatiiuk/site/javascript/code-generator',
  '/Users/maxpatiiuk/site/javascript/github-resolver',
  '/Users/maxpatiiuk/site/javascript/goodreads-stats',
  '/Users/maxpatiiuk/site/javascript/max.patii.uk',
  '/Users/maxpatiiuk/site/javascript/project-ephemeris',
  '/Users/maxpatiiuk/site/javascript/small-retail-management',
  '/Users/maxpatiiuk/site/javascript/text-hoarder',
  '/Users/maxpatiiuk/site/javascript/text-hoarder-store',
  '/Users/maxpatiiuk/site/javascript/tts-reader',
  //
  '/Users/maxpatiiuk/site/python/dir-explorer',
];

/**
 * List of repositories where it's safe to force push (because of history
 * rewrite) to any branch (unless a tag exists)
 */
const repositories = [
  ...activeRepositories,
  //
  '/Users/maxpatiiuk/site/migration/TTS_King',
  '/Users/maxpatiiuk/site/migration/alia',
  '/Users/maxpatiiuk/site/migration/amazon-contribution-sync',
  '/Users/maxpatiiuk/site/migration/clarity',
  '/Users/maxpatiiuk/site/migration/cycle2',
  '/Users/maxpatiiuk/site/migration/c_progams_generator',
  '/Users/maxpatiiuk/site/migration/eecs-448-battleship',
  '/Users/maxpatiiuk/site/migration/eecs-448-lab-8',
  '/Users/maxpatiiuk/site/migration/eecs-448-lab-9',
  '/Users/maxpatiiuk/site/migration/eecs-448-lab-10',
  '/Users/maxpatiiuk/site/migration/eecs-448-pixelland',
  '/Users/maxpatiiuk/site/migration/eecs-448-project-2',
  '/Users/maxpatiiuk/site/migration/eecs-662-final-project',
  '/Users/maxpatiiuk/site/migration/esri-contribution-sync',
  '/Users/maxpatiiuk/site/migration/esri-dev-summit-presentations',
  '/Users/maxpatiiuk/site/migration/fract',
  '/Users/maxpatiiuk/site/migration/goodreads-stats',
  '/Users/maxpatiiuk/site/migration/hiding_text_inside_image',
  '/Users/maxpatiiuk/site/migration/java-twister',
  '/Users/maxpatiiuk/site/migration/keys-database-conversion',
  '/Users/maxpatiiuk/site/migration/leto',
  '/Users/maxpatiiuk/site/migration/maxxxxxdlp',
  '/Users/maxpatiiuk/site/migration/maxxxxxdlp.github.io',
  '/Users/maxpatiiuk/site/migration/porter-stemming',
  '/Users/maxpatiiuk/site/migration/prettier-plugin-firebase-database',
  '/Users/maxpatiiuk/site/migration/pre-commit-tools',
  // Old email used inside of commit that is inside of merge commit - this script can't handle that
  // "/Users/maxpatiiuk/site/migration/pycharm_settings",
  '/Users/maxpatiiuk/site/migration/python_tts',
  '/Users/maxpatiiuk/site/migration/ramda-matrix',
  '/Users/maxpatiiuk/site/migration/shop.mambo.in.ua',
  '/Users/maxpatiiuk/site/migration/socksy.zzz.com.ua',
  '/Users/maxpatiiuk/site/migration/specify6-docker',
  '/Users/maxpatiiuk/site/migration/tetris-react',
  '/Users/maxpatiiuk/site/migration/typesafe-reducer',
  '/Users/maxpatiiuk/site/migration/university_jobs',
  '/Users/maxpatiiuk/site/migration/code-principles',
  '/Users/maxpatiiuk/site/migration/nginx-with-github-auth',
  '/Users/maxpatiiuk/site/migration/schema_to_html',
  '/Users/maxpatiiuk/site/migration/sp6-stats',
  '/Users/maxpatiiuk/site/migration/sp7-stats',
  '/Users/maxpatiiuk/site/migration/taxa_tree_docker',
  '/Users/maxpatiiuk/site/migration/taxa_tree_stats',
];

/**
 * List of repositories where force push (because of history rewrite) is only
 * allowed if:
 * - commit is not part of any tag
 * - commit is not part of main branch
 * - every branch that the commit is part of is included in the safeBranches
 *   set (defined below)
 */
const readOnlyRepositories = new Set([
  //
  '/Users/maxpatiiuk/site/git/specify6',
  //
  '/Users/maxpatiiuk/site/javascript/specify7-test-panel',
  //
  '/Users/maxpatiiuk/site/python/specify7',
  //
  '/Users/maxpatiiuk/site/migration-readonly/api_docs',
  '/Users/maxpatiiuk/site/migration-readonly/complexify',
  '/Users/maxpatiiuk/site/migration-readonly/core',
  '/Users/maxpatiiuk/site/migration-readonly/docker-compositions',
  '/Users/maxpatiiuk/site/migration-readonly/issues',
  '/Users/maxpatiiuk/site/migration-readonly/lifemapper.github.io',
  '/Users/maxpatiiuk/site/migration-readonly/lmclient',
  '/Users/maxpatiiuk/site/migration-readonly/lmpy',
  '/Users/maxpatiiuk/site/migration-readonly/lmtest',
  '/Users/maxpatiiuk/site/migration-readonly/lmtools',
  '/Users/maxpatiiuk/site/migration-readonly/lmtrex',
  '/Users/maxpatiiuk/site/migration-readonly/report-runner-service',
  '/Users/maxpatiiuk/site/migration-readonly/specify7-docker',
  '/Users/maxpatiiuk/site/migration-readonly/specify_network',
  '/Users/maxpatiiuk/site/migration-readonly/sp_network',
  '/Users/maxpatiiuk/site/migration-readonly/stinkbait',
  '/Users/maxpatiiuk/site/migration-readonly/student',
  '/Users/maxpatiiuk/site/migration-readonly/syftorium',
  '/Users/maxpatiiuk/site/migration-readonly/taxa_tree',
  '/Users/maxpatiiuk/site/migration-readonly/webportal-installer',
  '/Users/maxpatiiuk/site/migration-readonly/web-asset-server',
  '/Users/maxpatiiuk/site/migration-readonly/LFADS',
  '/Users/maxpatiiuk/site/migration-readonly/mirrors-jscpd',
  '/Users/maxpatiiuk/site/migration-readonly/open_api_tools',
]);

/**
 * Designates these branches in the list of repositories above as being safe
 * to edit history on.
 */
const safeBranches = new Set([
  'relocalization',
  'relocalization_dev',
  'json-schema',
  'collection-stats-charts',
  'special-characters',
  'weblate-localization',
]);

/**
 * The git author/name to use when rewriting history
 */
const canonicalAuthor = `Max Patiiuk <max@patii.uk>`;
const [canonicalName, canonicalEmail] = splitAuthor(canonicalAuthor);

/**
 * Deprecated occurrences of author/name/email that should be replaced with
 * canonicalAuthor
 *
 * Use steps.writeAuthorsShort() to help compile this list
 */
const deprecatedAuthors = new Set([
  'MAMBO <40512816+maxxxxxdlp@users.noreply.github.com>',
  'Maksym Paiiuk <maxxxxxdlp@gmail.com>',
  'Maksym Patiiuk <40512816+maxxxxxdlp@users.noreply.github.com>',
  'Maksym Patiiuk <git@mambo.in.ua>',
  'Maksym Patiiuk <info@mambo.in.ua>',
  'Max Patiiuk <40512816+maxxxxxdlp@users.noreply.github.com>',
  'Max Patiiuk <maxxxxxdlp@gmail.com>',
  'Max Patiiuk <patiiuk@amazon.com>',
  'Max Patiiuk <max@patii.uk>',
  'maxxxxxdlp <40512816+maxxxxxdlp@users.noreply.github.com>',
  'maxxxxxdlp <maxxxxxdlp@users.noreply.github.com>',
]);

/**
 * List of strings (case insensitive) that should be flagged for replacement
 */
const legacyDictionary = [
  'maxxxxxdlp',
  'maxxxxxxdlp',
  'maxxxxdlp',
  'maxxxxxflp',
  'maksym',
  'maxim',
  'gmail.com',
  'mambo',
  'com.ua',
  'noreply.github.com',
  'patiyuk',
  'patiuk',
  'pattiuk',
  'amazon.com',
  'ku.edu',
  'maxandqr',
  'andser',
  'patiua',
  'youtube.com',
  'facebook.com',
  'instagram.com',
  'vk.com',
  'goodreads.com',
  'linkedin.com',
  'twitter.com',
  'docs.google.com',
  'drive.google.com',
  'reddit.com',
  'spotify.com',
  'steam.com',
  'tumblr.com',
];

/**
 * If a line contains a string from the legacyDictionary, only include it if
 * it does not contain any string from the legacyMatchesExclude (case-insensitive)
 */
const legacyMatchesExclude = [
  'maxxxxxdlp/prettier-config',
  'maxxxxxdlp/eslint-config',
  'maxxxxxdlp/eslint-config-react',
  'maxxxxxdlp/stylelintrc',
  'maxxxxxdlp/stylelint-config',
];
const legacyCommitMessageMatchesExclude = [
  'Merge pull request ',
  "Merge branch '",
  'text-hoarder',
  'dependabot',
  'ku.edu',
];

/**
 * Path to the git-filter-repo executable
 *
 * It can be downloaded from here:
 * https://github.com/newren/git-filter-repo/blob/main/git-filter-repo
 */
const gitFilterRepoPath = '~/site/git/git-filter-repo/git-filter-repo';

const allRepositories = [...repositories, ...Array.from(readOnlyRepositories)];

const megabyte = 1024 * 1024;

const exec = (repository, command) =>
  execSync(command, {
    cwd: repository,
    // Fixes https://github.com/nodejs/node/issues/9829
    maxBuffer: 10 * megabyte,
  })
    .toString()
    .trim();

const steps = {
  /** Run git fetch in all actively used repositories */
  fetch() {
    activeRepositories.forEach((repository) => exec(repository, 'git fetch'));
  },
  /** Get unique list of all git authors and committers in all repositories */
  getAuthors() {
    const authors = allRepositories.map((repository) =>
      Array.from(
        new Set(
          steps
            .runLog(repository, '--all', [
              unsplitAuthor('%an', '%ae'),
              unsplitAuthor('%cn', '%ce'),
            ])
            .flat()
        )
      ).map((author) => ({
        repository,
        author,
        isReadOnly: readOnlyRepositories.has(repository),
      }))
    );
    const groupped = Object.fromEntries(
      Object.entries(
        authors.flat().reduce((total, { author, ...rest }) => {
          total[author] ??= [];
          total[author].push(rest);
          return total;
        }, {})
      ).sort(([authorA], [authorB]) => authorA.localeCompare(authorB))
    );
    return groupped;
  },
  /** Write result of getAuthors and metadata to list */
  writeAuthors(authors = steps.getAuthors()) {
    fs.writeFileSync('./authors.json', JSON.stringify(authors, null, 2));
  },
  /** Write only author names from getAuthors and metadata to list */
  writeAuthorsShort(authors = steps.getAuthors()) {
    fs.writeFileSync(
      './authors.json',
      JSON.stringify(Object.keys(authors), null, 2)
    );
  },
  /** Read a previously written writeAuthors or writeAuthorsShort */
  readAuthors() {
    return JSON.parse(fs.readFileSync('./authors.json').toString());
  },
  /**
   * Filter list of authors to your authors only, as defined by canonicalAuthor
   * and deprecatedAuthors
   */
  getMyAuthors(allAuthors = steps.getAuthors(), includeCanonical = false) {
    return Object.fromEntries(
      Object.entries(allAuthors)
        .filter(
          ([author]) =>
            (includeCanonical && author === canonicalAuthor) ||
            deprecatedAuthors.has(author)
        )
        .sort(([authorA], [authorB]) => authorA.localeCompare(authorB))
    );
  },
  /**
   * Helper for running "git log" and parsing the results
   */
  runLog(repository, command, formatters) {
    const separator = ' ç ';
    return exec(
      repository,
      `git log ${command} --pretty=format:"${formatters.join(separator)}"`
    )
      .split('\n')
      .map((line) => line.split(separator));
  },
  /**
   * For each git author, fetch list of commits and decide if the commits are
   * safe to augment with canonicalAuthor
   */
  augmentAuthorsWithCommits(
    authors = steps.getMyAuthors(),
    excludeNonEditable = true
  ) {
    const repositoryCommits = Object.fromEntries(
      Array.from(
        new Set(
          Object.values(authors).flatMap((repositories) =>
            repositories.map(({ repository }) => repository)
          )
        )
      ).map((repository) => [
        repository,
        steps.runLog(repository, `--all`, [
          unsplitAuthor('%an', '%ae'),
          unsplitAuthor('%cn', '%ce'),
          '%H',
          '%ci',
          '%f',
        ]),
      ])
    );
    return Object.fromEntries(
      Object.entries(authors).map(([author, repositories]) => [
        author,
        repositories
          .map(({ repository, ...rest }) => ({
            ...rest,
            repository,
            mainBranch: exec(
              repository,
              "git symbolic-ref refs/remotes/origin/HEAD | sed 's@^refs/remotes/origin/@@'"
            ),
            commits: repositoryCommits[repository]
              .filter(
                ([authorName, committerName]) =>
                  authorName === author || committerName === author
              )
              .map(([_author, _committer, hash, date, message]) => ({
                hash,
                date,
                message,
                tags: exec(repository, `git tag --contains ${hash}`)
                  .split('\n')
                  .filter(Boolean),
                branches: (
                  exec(repository, `git branch --contains ${hash}`) ||
                  exec(repository, `git branch --all --contains ${hash}`)
                )
                  .split('\n')
                  .map((branch) =>
                    branch.replace(/^\* /, '').split('/').at(-1)?.trim()
                  ),
              })),
          }))
          .map(({ isReadOnly, mainBranch, commits, ...rest }) => ({
            ...rest,
            isReadOnly,
            mainBranch,
            commits: commits
              .map((commit) => {
                const isOnMainBranch = commit.branches.includes(mainBranch);
                const isInTag = commit.tags.length > 0;

                return {
                  safeToEdit: !isReadOnly
                    ? true
                    : isInTag || isOnMainBranch
                    ? false
                    : commit.branches.every((branch) =>
                        safeBranches.has(branch)
                      )
                    ? true
                    : false,
                  ...commit,
                };
              })
              .filter((commit) => !excludeNonEditable || commit.safeToEdit)
              .map((commit) => {
                if (commit.tags.length > 0) {
                  console.error({ repository: rest, commit });
                  throw new Error(
                    "Encountered a tag in a non-read-only repository's commit"
                  );
                }
                if (commit.branches > 1) {
                  console.error({ repository: rest, commit });
                  throw new Error(
                    'Unhandled case: commit on more than one branch'
                  );
                }
                return commit;
              }),
          }))
          .filter(({ commits }) => commits.length > 0),
      ])
    );
  },
  /**
   * Group result of augmentAuthorsWithCommits by repository, branch and commit
   * rather than git author
   */
  groupForRebase(authors = steps.readAuthors()) {
    return Object.values(authors)
      .flat()
      .flatMap((repositories) =>
        repositories.commits.map(({ branches, ...commit }) => ({
          shortHash: commit.hash.slice(0, 7),
          repository: repositories.repository,
          branch: branches[0],
          ...commit,
        }))
      )
      .reduce((total, { repository, branch, hash, ...commit }) => {
        total[repository] ??= {};
        total[repository][branch] ??= {};
        total[repository][branch][hash] = commit;
        return total;
      }, {});
  },
  /** Write result of groupForRebase to disk for inspection */
  writeGroupped(groupped = steps.groupForRebase()) {
    fs.writeFileSync('./group.json', JSON.stringify(groupped, null, 2));
  },
  /** See list of commits where author and committer is different */
  compareAuthoredAndCommitted(groupped = steps.groupForRebase()) {
    return Object.entries(groupped).flatMap(([repository, branches]) =>
      Object.entries(branches)
        .flatMap(([branch, commits]) =>
          Object.keys(commits).map((hash) => {
            const [
              [
                authorName,
                authorEmail,
                authorDate,
                commitName,
                commitEmail,
                commitDate,
              ],
            ] = steps.runLog(repository, `-1 ${hash}`, [
              '%an',
              '%ae',
              '%ai',
              '%cn',
              '%ce',
              '%ci',
            ]);
            if (authorEmail !== commitEmail || authorName !== commitName)
              return {
                repository,
                branch,
                hash,
                authorName,
                authorEmail,
                authorDate,
                commitName,
                commitEmail,
                commitDate,
              };
            else return undefined;
          })
        )
        .filter(Boolean)
    );
  },
  /** Write result of compareAuthoredAndCommitted to disk for inspection */
  writeComparison(groupped = steps.compareAuthoredAndCommitted()) {
    fs.writeFileSync('./compare.json', JSON.stringify(groupped, null, 2));
  },
  /** Convert JS set/array to Python set string */
  jsSetToPythonSet(set) {
    return `{${Array.from(set)
      .map((value) => `"${value}"`)
      .join(', ')}}`;
  },
  /**
   * For a given commit on some branch in a repository, create a string that git
   * interprets as "all commits from current (inclusive) till the most recent on
   * that branch".
   *
   * @remarks
   * If the commit is the first one, returns the branch name
   */
  getAllAfterCommitInclusive(repository, branch, hash) {
    const parentSha = exec(
      repository,
      `git log --pretty=%P -n 1 ${hash}`
    ).slice(0, 7);
    return parentSha === '' ? branch : `${parentSha}...`;
  },
  /**
   * Replace deprecatedAuthors with canonicalAuthor where safe
   */
  updateCommits(groupped = steps.groupForRebase()) {
    Object.entries(groupped).forEach(([repository, branches]) =>
      Object.entries(branches).forEach(([branch, commits]) => {
        const workingTreeClean =
          exec(repository, 'git diff-index HEAD --').length === 0;
        if (!workingTreeClean)
          throw new Error(
            `Unable to migrate ${repository} because working tree not clean`
          );

        const currentBranch = exec(repository, `git symbolic-ref --short HEAD`);
        if (branch !== currentBranch)
          exec(repository, `git checkout ${branch}`);

        try {
          const aheadBehindBy = exec(
            repository,
            `git rev-list --left-right --count HEAD...origin/${branch}`
          );
          if (aheadBehindBy !== '0\t0')
            throw new Error(
              `Unable to migrate ${repository} because it is ahead or behind origin/${branch} by ${aheadBehindBy}`
            );
          console.log(repository);
          exec(
            repository,
            // These callbacks are simpler than --commit-callback, but don't allow for selectively replacing commits:
            // --name-callback 'return b"${canonicalName}" if name.decode("utf-8") in ${steps.jsSetToPythonSet(
            // deprecatedNames
            // )} else name' \
            // --email-callback 'return b"${canonicalEmail}" if email.decode("utf-8") in ${steps.jsSetToPythonSet(
            // deprecatedEmails
            // )} else email' \
            `
${gitFilterRepoPath} \
  --force \
  --partial \
  --refs ${steps.getAllAfterCommitInclusive(
    repository,
    branch,
    Object.keys(commits).at(-1)
  )} \
  --commit-callback '
    deprecated_authors = ${steps.jsSetToPythonSet(deprecatedAuthors)}
    commits_to_edit = ${steps.jsSetToPythonSet(Object.keys(commits))}
    if commit.original_id.decode("utf-8") in commits_to_edit:
        formatted_author = (commit.author_name + b" <" + commit.author_email + b">").decode("utf-8")
        if formatted_author in deprecated_authors:
            commit.author_name = b"${canonicalName}"
            commit.author_email = b"${canonicalEmail}"
        formatted_committer = (commit.committer_name + b" <" + commit.committer_email + b">").decode("utf-8")
        if formatted_committer in deprecated_authors:
            commit.committer_name = b"${canonicalName}"
            commit.committer_email = b"${canonicalEmail}"
  '
`
          );
        } finally {
          if (branch !== currentBranch)
            exec(repository, `git checkout ${currentBranch}`);
        }
      })
    );
  },
  /**
   * Convert path segments to a tree branch, with "leaf" as an array item at
   * the end of the tree's branch
   */
  climbTree(base, branch, leaf) {
    if (branch.length === 1) {
      base[branch[0]] ??= [];
      base[branch[0]].push(leaf);
    } else
      base[branch[0]] = steps.climbTree(
        base[branch[0]] ?? {},
        branch.slice(1),
        leaf
      );
    return base;
  },
  /**
   * Reverse of climbTree - for a given tree, get list of all paths, and their
   * contents
   */
  climbPath: (tree, basePath) =>
    Object.entries(tree).flatMap(([pathPart, contents]) => {
      const fullPath = join(basePath, pathPart);
      if (Array.isArray(contents)) return [[fullPath, contents]];
      else return steps.climbPath(contents, fullPath);
    }),
  /**
   * Search all repositories for all occurrences of legacy strings
   */
  searchForLegacy() {
    return Object.fromEntries(
      allRepositories.map((repository) => [
        repository,
        exec(
          repository,
          `git grep --ignore-case -I ${legacyDictionary
            .map((word) => `-e "${word}"`)
            .join(' ')} || true`
        )
          .split('\n')
          .reduce((tree, line) => {
            const separator = line.indexOf(':');
            const pathParts = line.slice(0, separator).split('/');
            const occurrence = line.slice(separator + 1);
            const isExcluded = legacyMatchesExclude.some((exclude) =>
              occurrence.includes(exclude)
            );
            if (!isExcluded) steps.climbTree(tree, pathParts, occurrence);

            return tree;
          }, {}),
      ])
    );
  },
  /**
   * Write result of searchForLegacy to disk for inspection and editing
   */
  writeSearch(search = steps.searchForLegacy()) {
    fs.writeFileSync('./search.json', JSON.stringify(search, null, 2));
  },
  readSearch() {
    return JSON.parse(fs.readFileSync('./search.json').toString());
  },
  readOldSearch() {
    return JSON.parse(fs.readFileSync('./search-old.json').toString());
  },
  /**
   * Workflow:
   * - Run writeSearch()
   * - Make a copy of search.json as search-old.json
   * - (optional) Commit that to a temporary git repository so that IDE can show
   *   the changes you are making
   * - Use editors search and replace or manual edits to replace the
   *   legacyDictionary as needed
   *   - if you don't want to replace some usage, just leave it unchanged in the
   *     file
   *   - The search.json is a JSON file, thus you can use IDE's folding feature
   *     to fold entire folders/files that you want to exclude
   * - Run replaceLegacy() to replace all legacy occurrences
   */
  replaceLegacy(
    // Make a diff of edits that would be made to double check that all looks good
    writeDiff = true,
    // Actually write the changes to disk
    writeChanges = false,
    search = steps.readSearch(),
    oldSearch = steps.readOldSearch()
  ) {
    const flattenSearch = (search) =>
      Object.entries(search)
        .flatMap(([repository, files]) => steps.climbPath(files, repository))
        .map(([path, replacements]) => [
          path,
          replacements.filter((line) => line.length > 0),
        ])
        .filter(([_path, replacements]) => replacements.length > 0);

    const oldSearchFlat = Object.fromEntries(flattenSearch(oldSearch));
    const old = [];
    const neww = [];
    flattenSearch(search).forEach(([path, replacements]) => {
      if (path === '') return;
      const matches = oldSearchFlat[path];
      if (matches === undefined)
        throw new Error(`No matches found for path ${path}`);
      if (matches.length !== replacements.length)
        throw new Error(
          `Number of matches ${matches.length} does not match number of replacements ${replacements.length} for path ${path}`
        );

      const contents = fs.readFileSync(path).toString().split('\n');
      const newContents = contents
        .map((line) => {
          const match = matches.indexOf(line);
          const replace = match !== -1 && line !== replacements[match];
          if (replace) {
            old.push(line);
            neww.push(replacements[match]);
          }
          return replace ? replacements[match] : line;
        })
        .join('\n');
      if (writeChanges) fs.writeFileSync(path, newContents);
    });
    if (writeDiff) {
      fs.writeFileSync('./search.diff.old.txt', old.join('\n'));
      fs.writeFileSync('./search.diff.new.txt', neww.join('\n'));
    }
  },
  searchForLegacyInGitCommitMessages() {
    return allRepositories
      .map((repository) => [
        repository,
        exec(repository, 'git log --all')
          .split('\ncommit ')
          .filter((commit) => {
            const filteredContents = commit
              .split('\n')
              .filter((line) => !line.startsWith('Author:'))
              .join('\n');
            return (
              legacyDictionary.some((word) =>
                filteredContents.includes(word)
              ) &&
              !legacyCommitMessageMatchesExclude.some((word) =>
                commit.includes(word)
              )
            );
          }),
      ])
      .filter(([_repository, commits]) => commits.length > 0);
  },
  writeLegacyInGitCommitMessages(
    search = steps.searchForLegacyInGitCommitMessages()
  ) {
    fs.writeFileSync(
      './search-commit-messages.txt',
      search.map((data) => data.join('\n')).join('\n\n\n')
    );
  },
  reportDirtyStatuses() {
    allRepositories.forEach((repository) => {
      console.log(`\n\nRepository: ${repository}`);
      const workingTree = exec(repository, 'git diff-index HEAD --');
      if (workingTree.length > 0)
        console.log(`Working tree not clean:\n${workingTree}`);

      const currentBranch = exec(repository, `git symbolic-ref --short HEAD`);
      const [aheadBy, behindBy] = exec(
        repository,
        `git rev-list --left-right --count HEAD...origin/${currentBranch}`
      ).split('\t');
      if (aheadBy !== '0')
        console.log(`Ahead of origin/${currentBranch} by ${aheadBy} commits`);
      if (behindBy !== '0')
        console.log(`Behind origin/${currentBranch} by ${behindBy} commits`);

      const stashCount = exec(repository, `git stash list | wc -l`);
      if (stashCount !== '0')
        console.log(`Repository contains ${stashCount} stashed changes`);
    });
  },
};

function splitAuthor(author) {
  return author.slice(0, -1).split(' <');
}
function unsplitAuthor(name, email) {
  return `${name} <${email}>`;
}

/**
 * # Working area
 *
 * All steps and helper functions are defined in the "steps" object above.
 * Now here you can write the small temporary scripts that call the necessary
 * steps.
 * Common use case is run one step, look at the output file, make edits if
 * necessary, then run some other step functions.
 *
 * @example
 * steps.writeAuthors();
 * // or
 * steps.writeSearch();
 * // or
 * steps.reportDirtyStatuses();
 */

steps.reportDirtyStatuses();
console.log('Completed!');
