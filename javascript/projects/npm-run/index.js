import fs from 'node:fs';
import path from 'node:path';

const cwd = process.cwd();

const scriptCandidates = [];

let packageManager = undefined;

{
  const pathParts = cwd.split(path.sep);
  while (pathParts.length > 1) {
    const packageJson = path.join(pathParts.join(path.sep), 'package.json');
    pathParts.pop();
    if (!fs.existsSync(packageJson)) continue;

    const contents = JSON.parse(fs.readFileSync(packageJson, 'utf8'));
    if (typeof contents !== 'object' || Array.isArray(contents)) continue;

    scriptCandidates.push(...Object.keys(contents?.scripts ?? {}));

    if (typeof contents.packageManager === 'string')
      packageManager ??=
        contents.packageManager.match(/\w+/u)?.[0] ?? packageManager;
  }
}

packageManager ??= 'npm';

const commandName = process.argv[2];
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

const formattedArguments = process.argv
  .slice(3)
  .map((part) =>
    part.includes(' ') || part.includes('"')
      ? `"${part.replace('"', '\\"')}"`
      : part
  )
  .join(' ');

// Resolve npm scripts
const resolvedScript = resolve(scriptCandidates);
if (typeof resolvedScript === 'string') {
  console.log(
    `${packageManager} run ${resolvedScript} ${
      packageManager === 'npm' && process.argv.length > 3 ? '-- ' : ''
    }${formattedArguments}`
  );
  process.exit(0);
}

// Resolve npm binaries
const binaryCandidates = [];
{
  const pathParts = cwd.split(path.sep);
  while (pathParts.length > 1) {
    const binaries = path.join(pathParts.join(path.sep), 'node_modules/.bin');
    pathParts.pop();
    if (!fs.existsSync(binaries)) continue;

    const files = fs.readdirSync(binaries);
    binaryCandidates.push(...files);
  }
}

/**
 * Sort so that if command is "vite", it is matched before "vitest".
 */
const resolvedBinary = resolve(binaryCandidates.sort()) ?? commandName;

console.log(`npx ${resolvedBinary} ${formattedArguments}`);
