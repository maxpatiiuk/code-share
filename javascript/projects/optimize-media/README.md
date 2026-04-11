# optimize-media

Tiny Node.js CLI that converts images to AVIF with `sharp` and prints size
savings.

## Usage

```bash
node index.js photo.jpeg
node index.js --input photo.jpeg --output photo.avif
node index.js *.jpeg
node index.js --input a.jpeg --input b.jpeg
node index.js photo.jpeg --no-delete-original
```
