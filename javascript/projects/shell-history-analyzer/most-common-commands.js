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

const commonCommands = Object.entries(
  historyLines.reduce((acc, line) => {
    acc[line] = (acc[line] || 0) + 1;
    return acc;
  }, {})
).sort((a, b) => b[1] - a[1]);

writeFileSync(
  'most-common-commands.json',
  JSON.stringify(commonCommands, null, 2)
);
