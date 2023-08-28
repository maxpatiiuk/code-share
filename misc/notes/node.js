/**
 * Based on https://exploringjs.com/nodejs-shell-scripting/
 */
import assert from 'node:assert/strict';

/** OS */
import os from 'node:os';

assert.equal(os.homedir(), os.userInfo().homedir);

/** Path */
import path, { join } from 'node:path';

// Current directory
path.cwd();
// Change directory
path.chdir();

// By default, path API uses current OS settings. Can choose some a
// different system explicitly:
path.posix['any'];
// path.posix.sep
path.win32['any'];

// Resolve absolute path // Also, normalizes
path.resolve('/a/b', 'a', '..');
// Join relative paths // Also, normalizes
path.join('a/b', 'c', '..');
// Normalize path
path.normalize('/home/./a///b/../c');
assert.equal(path.relative('/a/b/', '/a/b/c/d'), 'c/d');
path.format(path.parse('/a/b/c.txt'));
assert.equal(path.basename('/a/b/c.txt'), 'c');
assert.equal(path.basename('/a/b/c.d.ts', '.d.ts'), 'c');
assert.equal(path.extname('/a/b/c.txt'), '.txt');
assert.equal(path.dirname(path.dirname('/a/b/c.txt')), '/a');
path.isAbsolute('/a/b');

// glob matching libs: minimatch, multimatch, globby, glob, fast-glob

/** Url */
import { URL, fileURLToPath, pathToFileURL } from 'node:url';
const url = new URL('./a', 'https://localhost/');
url.toString();
url.toJSON();
url.searchParams;
assert.equal(fileURLToPath(new URL('file:///a/b/c.txt')), '/a/b/c.txt');
pathToFileURL('/a/b/c.txt');

/** File system */
import fs from 'node:fs/promises';
import fsLegacy from 'node:fs';
await fs.readFile('./a.txt', { encoding: 'utf8' });
fsLegacy.readFileSync('./a.txt', { encoding: 'utf8' });
(await fs.open('./a.txt')).close();

fs.readFile(new URL('data.txt', import.meta.url), { encoding: 'utf8' });
await fetch('file:///tmp/file.txt');

const RE_SPLIT_EOL = /\r?\n/;
RE_SPLIT_EOL || os.EOL;

const pathPrefix = path.resolve(os.tmpdir(), 'my-app');
// e.g. '/var/folders/ph/sz0384m11vxf/T/my-app'
console.log({ tempPath: fsLegacy.mkdtempSync(pathPrefix) });

// import trash from 'trash';
// await trash(['*.png', '!rainbow.png']);

// Symboling Links and Hard Links

/** Streams */

// Legacy Node.js Specific:
fsLegacy.createReadStream || fsLegacy.createWriteStream;

// Web Streams
const streams = await import('node:stream/web');
ReadableStream || WritableStream || TransformStream;
// Can split to read twice separately using tee()
// Can have text or binary streams
// Can have backpressure (automatically adjusts speed of data flow to match performance of every node)

/** child_process */
import { spawn, spawnSync } from 'node:child_process';

const child = spawn('ls', ['-a', '-l'], {
  cwd: '/tmp',
  stdio: 'inherit',
  shell: true,
  env: { PATH: '/usr/local/bin' },
});

spawnSync('echo', ['Command starts'], {
  stdio: 'inherit',
  shell: true,
});

/** package.json */
console.log(`
// See env variables available for package.json scripts
npm run env
// Enable very verbose logging:
npm -ddd i
// All: https://exploringjs.com/nodejs-shell-scripting/ch_package-scripts.html#npm-log-level

`);
