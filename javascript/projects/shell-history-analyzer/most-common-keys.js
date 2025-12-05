import { writeFileSync, readFileSync, readdirSync } from 'fs';

const arg = process.argv[2] ?? '.';
const occurrences = {};

readdirSync(arg, { recursive: true, withFileTypes: true }).forEach((file) => {
  if (file.isDirectory()) {
    return;
  }
  console.log(`Processing ${file.parentPath}/${file.name}`);
  const content = readFileSync(`${file.parentPath}/${file.name}`, 'utf8');
  const extension = file.name.split('.').pop();
  content.split('').forEach((char) => {
    occurrences[extension] ??= {};
    occurrences[extension][char] ??= 0;
    occurrences[extension][char]++;
    occurrences[''] ??= {};
    occurrences[''][char] ??= 0;
    occurrences[''][char]++;
  });
});

const sorted = Object.entries(occurrences)
  .map(([key, value]) => [
    key,
    Object.entries(value).sort((a, b) => b[1] - a[1]),
  ])
  .sort(
    (a, b) =>
      b[1].reduce((acc, curr) => acc + curr[1], 0) -
      a[1].reduce((acc, curr) => acc + curr[1], 0)
  );
writeFileSync('most-common-keys.json', JSON.stringify(sorted, null, 2));
