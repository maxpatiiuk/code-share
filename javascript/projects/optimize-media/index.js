#!/usr/bin/env node

import fs from 'node:fs/promises';
import path from 'node:path';
import { parseArgs, styleText } from 'node:util';
import sharp from 'sharp';

const { values, positionals } = parseArgs({
  options: {
    input: {
      type: 'string',
      short: 'i',
      multiple: true,
    },
    output: {
      type: 'string',
      short: 'o',
    },
    help: {
      type: 'boolean',
      short: 'h',
      default: false,
    },
    'no-delete-original': {
      type: 'boolean',
      default: false,
    },
  },
  allowPositionals: true,
});

if (values.help) {
  console.log(
    `Usage:\n  node index.js <input-image> [--output output.avif]\n  node index.js <input-image> <input-image> ...\n  node index.js --input <input-image> [--input <input-image> ...] [--output output.avif]\n  node index.js <input-image> --no-delete-original`
  );
  process.exit(0);
}

const inputFiles = [...positionals, ...(values.input ?? []).filter(Boolean)];

if (inputFiles.length === 0) {
  console.error('Missing input image path. Use --help for usage.');
  process.exit(1);
}

if (values.output && inputFiles.length > 1) {
  console.error('`--output` can only be used with a single input file.');
  process.exit(1);
}

const shouldDeleteOriginal = !values['no-delete-original'];

/** @param {number} bytes */
const toKb = (bytes) => (bytes / 1024).toFixed(2);

let originalTotalSize = 0;
let newTotalSize = 0;

for (const [index, inputFile] of inputFiles.entries()) {
  const { inputSize, outputSize } = await processFile(
    inputFile,
    index,
    inputFiles.length
  );

  originalTotalSize += inputSize;
  newTotalSize += outputSize;
}

const savedBytes = originalTotalSize - newTotalSize;
const savedPercent =
  originalTotalSize === 0
    ? '0.00'
    : ((savedBytes / originalTotalSize) * 100).toFixed(2);

console.log(
  `Reduced file sizes from ${styleText(
    'red',
    `${toKb(originalTotalSize)} KB`
  )} to ${styleText('green', `${toKb(newTotalSize)} KB`)}. Saved ${styleText(
    savedBytes >= 0 ? 'green' : 'red',
    `${savedBytes >= 0 ? '-' : '+'}${toKb(Math.abs(savedBytes))} KB`
  )} in total (${styleText(
    savedBytes >= 0 ? 'green' : 'red',
    `${
      savedBytes >= 0 ? savedPercent : Math.abs(Number(savedPercent)).toFixed(2)
    }%`
  )})`
);

/** @param {string} inputFile @param {number} index @param {number} total */
async function processFile(inputFile, index, total) {
  const outputFile = getOutputFile(inputFile);

  await sharp(inputFile)
    .avif({
      // Max effort because image compression is fast
      effort: 9,
      // Compress color range to human-perceptible range
      chromaSubsampling: '4:2:0',
    })
    .toFile(outputFile);

  const [inputStat, outputStat] = await Promise.all([
    fs.stat(inputFile),
    fs.stat(outputFile),
  ]);

  const savedBytes = inputStat.size - outputStat.size;
  const reductionPercent = ((savedBytes / inputStat.size) * 100).toFixed(2);

  const originalSize = `${toKb(inputStat.size)} KB`;
  const optimizedSize = `${toKb(outputStat.size)} KB`;
  const deltaSize = `${savedBytes >= 0 ? '-' : '+'}${toKb(
    Math.abs(savedBytes)
  )} KB`;
  const deltaPercent = `${
    savedBytes >= 0
      ? reductionPercent
      : Math.abs((savedBytes / inputStat.size) * 100).toFixed(2)
  }%`;
  const progress = `[${index + 1}/${total}]`;

  console.log(
    `${styleText('yellow', progress)} ${styleText(
      'cyan',
      outputFile
    )} | ${styleText('red', originalSize)} -> ${styleText(
      'green',
      optimizedSize
    )} | ${styleText(
      savedBytes >= 0 ? 'green' : 'red',
      `${deltaSize} (${deltaPercent})`
    )}`
  );

  if (shouldDeleteOriginal && outputFile !== inputFile) {
    await fs.unlink(inputFile);
  }

  return {
    inputSize: inputStat.size,
    outputSize: outputStat.size,
  };
}

/** @param {string} inputFile */
function getOutputFile(inputFile) {
  if (values.output) {
    return values.output;
  }

  const ext = path.extname(inputFile);
  return path.join(
    path.dirname(inputFile),
    `${path.basename(inputFile, ext)}.avif`
  );
}
