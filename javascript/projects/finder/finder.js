import path from 'node:path';
import fs from 'node:fs';

const target = process.argv[2];

let directory = process.cwd();

while (true) {
  const exists = fs.existsSync(path.join(directory, target));
  if (exists) {
    console.log(directory);
    process.exit(0);
  }
  if (directory === path.parse(directory).root) {
    process.exit(1);
  }
  directory = path.dirname(directory);
}
