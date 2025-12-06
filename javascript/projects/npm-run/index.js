import fs from 'node:fs';
import path from 'node:path';

const cwd = process.cwd();

let localScripts = undefined;
const globalScriptsMap = new Map();

let packageManager = undefined;

{
  const pathParts = cwd.split(path.sep);
  while (pathParts.length > 2) {
    const currentDir = pathParts.join(path.sep);
    const packageJsonPath = path.join(currentDir, 'package.json');
    pathParts.pop();
    if (!fs.existsSync(packageJsonPath)) continue;

    const packageJson = JSON.parse(fs.readFileSync(packageJsonPath, 'utf8'));
    if (typeof packageJson !== 'object' || Array.isArray(packageJson)) continue;

    if (packageJson.scripts) {
      if (localScripts === undefined) {
        localScripts = Object.keys(packageJson?.scripts ?? {}).sort(
          (left, right) => left.length - right.length
        );
      } else {
        for (const [name, cmd] of Object.entries(packageJson.scripts)) {
          if (!globalScriptsMap.has(name)) {
            globalScriptsMap.set(name, { name, cmd, cwd: currentDir });
          }
        }
      }
    }

    if (typeof packageJson.packageManager === 'string')
      packageManager ??=
        packageJson.packageManager.match(/\w+/u)?.[0] ?? packageManager;
  }
}

packageManager ??= 'npm';

const parameters = process.argv.slice(2);
let commandName = parameters.shift();

let nodeFlags = '';
if (
  commandName?.startsWith('--inspect') ||
  commandName?.startsWith('--inspect-brk') ||
  commandName?.startsWith('--inspectBrk') ||
  commandName?.startsWith('--inspect-wait') ||
  commandName?.startsWith('--inspectWait')
) {
  const hasNodeOptions = process.env.NODE_OPTIONS !== undefined;
  const prefix = hasNodeOptions ? `"$NODE_OPTIONS ` : '';
  nodeFlags = `NODE_OPTIONS=${prefix}${commandName
    .replace('inspectBrk', 'inspect-brk')
    .replace('inspectWait', 'inspect-wait')}" `;
  commandName = parameters.shift();
}

if (commandName === undefined) {
  console.log('# Usage: x <short-command> [args...]');
  process.exit(1);
}
const split = (name) =>
  name.split(':').map((part) => part.split('.').map((part) => part.split('-')));
const parts = split(commandName);

// s -> s.*
// s:x -> s.*:x.*
function resolve(candidates) {
  for (const candidate of candidates) {
    const candidateParts = split(candidate);
    if (
      parts.every((subParts, index) =>
        subParts.every((subSubParts, subIndex) =>
          subSubParts.every(
            (part, subSubIndex) =>
              candidateParts[index]?.[subIndex]?.[subSubIndex]?.startsWith(
                part
              ) === true
          )
        )
      )
    )
      return candidate;
  }
  return undefined;
}

const formattedArguments = parameters.map((part) =>
  part.includes(' ') || part.includes('"')
    ? `"${part.replace('"', '\\"')}"`
    : part
);

// Resolve npm scripts
let resolvedScript = resolve(localScripts ?? []);
if (resolvedScript) {
  console.log(
    `${nodeFlags}node --run ${resolvedScript}${
      formattedArguments.length > 0 ? ' -- ' + formattedArguments.join(' ') : ''
    }`
  );
  process.exit(0);
} else {
  resolvedScript = resolve(Array.from(globalScriptsMap.keys()));
  if (resolvedScript) {
    const match = globalScriptsMap.get(resolvedScript);

    const targetCwd = match.cwd;
    const isLocal = targetCwd === process.cwd();

    let normalizedArguments = formattedArguments;

    if (!isLocal && normalizedArguments.length > 0) {
      normalizedArguments = normalizedArguments.map((arg) => {
        // Rewrite relative paths arguments to absolute
        if (fs.existsSync(arg)) {
          return path.resolve(process.cwd(), arg);
        }
        return arg;
      });
    }

    const argsString =
      normalizedArguments.length > 0
        ? ` -- ${normalizedArguments.join(' ')}`
        : '';
    const command = `(cd "${targetCwd}" && ${nodeFlags}node --run ${resolvedScript}${argsString})`;

    console.log(command);
    process.exit(0);
  }
}

// Resolve npm binaries
const binaryMap = new Map();
{
  const pathParts = cwd.split(path.sep);
  while (pathParts.length > 2) {
    const binDir = path.join(pathParts.join(path.sep), 'node_modules/.bin');
    pathParts.pop();

    if (!fs.existsSync(binDir)) continue;

    const files = fs.readdirSync(binDir);

    for (const file of files) {
      // Closest binary wins
      if (!binaryMap.has(file)) {
        binaryMap.set(file, binDir);
      }
    }
  }
}

const binaryCandidates = Array.from(binaryMap.keys());
/**
 * Sort so that if command is "vite", it is matched before "vitest".
 */
const resolvedBinary = resolve(binaryCandidates.sort());
let executablePath = 'npx ' + commandName;
const binaryLocation = binaryMap.get(resolvedBinary);
if (binaryLocation !== undefined) {
  executablePath = path.relative(
    process.cwd(),
    path.join(binaryLocation, resolvedBinary)
  );
}

console.log(`${nodeFlags}${executablePath} ${formattedArguments.join(' ')}`);
