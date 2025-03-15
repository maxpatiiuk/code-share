import { readFileSync, writeFileSync } from 'fs';

const homeDir = process.env.HOME;
const historyFile = `${homeDir}/.zsh_history`;
const history = readFileSync(historyFile, 'utf8').split('\n');
const historyLines = history
  .map((line) => {
    const command = line.slice(line.indexOf(';') + 1);
    return command;
  })
  .filter(Boolean);

const groupedBySubcommands = historyLines.reduce((acc, line) => {
  const [command, ...subcommands] = line.split(' ');
  if (!subcommands.length) {
    return acc;
  }
  acc[command] ??= {};
  acc[command][subcommands.join(' ')] ??= 0;
  acc[command][subcommands.join(' ')] += 1;
  return acc;
}, {});

const sorted = Object.fromEntries(
  Object.entries(groupedBySubcommands)
    .map(([command, subcommands]) => {
      const sortedSubcommands = Object.entries(subcommands).sort(
        (a, b) => b[1] - a[1]
      );
      return [command, sortedSubcommands];
    })
    .sort(
      (a, b) =>
        b.reduce((acc, [_, count]) => acc + count, 0) -
        a.reduce((acc, [_, count]) => acc + count, 0)
    )
);

writeFileSync('most-common-subcommands.json', JSON.stringify(sorted, null, 2));
