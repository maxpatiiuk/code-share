import fs from 'node:fs';
import path from 'node:path';
const cwd = process.cwd();

const candidates = [];

let packageManager = undefined;

{
  const pathParts = cwd.split(path.sep);
  while (pathParts.length > 1) {
    const packageJson = path.join(pathParts.join(path.sep), 'package.json');
    pathParts.pop();
    if (!fs.existsSync(packageJson)) continue;

    const contents = JSON.parse(fs.readFileSync(packageJson, 'utf8'));
    if (typeof contents !== 'object' || Array.isArray(contents)) continue;

    candidates.push(...Object.keys(contents?.scripts ?? {}));

    if (typeof contents.packageManager === 'string')
      packageManager ??=
        contents.packageManager.match(/\w+/u)?.[0] ?? packageManager;
  }
}

packageManager ??= 'npm';

const commandName = process.argv[2];
const parts = commandName.split(':').map((part) => part.split('.'));

function resolve(commandName) {
  console.log(
    `${packageManager} run ${commandName} ${
      packageManager === 'npm' && process.argv.length > 2 ? '-- ' : ''
    }${process.argv.slice(3).join(' ')}`
  );
  process.exit(0);
}

// s -> s.*
// s:x -> s.*:x.*
for (const candidate of candidates) {
  const candidateParts = candidate.split(':').map((part) => part.split('.'));
  if (
    parts.every((subParts, index) =>
      subParts.every(
        (part, subIndex) =>
          candidateParts[index]?.[subIndex]?.startsWith(part) === true
      )
    )
  )
    resolve(candidate);
}

console.log(`npx ${commandName} ${process.argv.slice(3).join(' ')}`);
