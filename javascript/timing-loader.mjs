// timing-loader.mjs
//
// Run:
// node --experimental-loader ./timing-loader.mjs your-cli.mjs

const threathold = 1;

export async function resolve(specifier, context, next) {
  const t0 = performance.now();
  const res = await next(specifier, context);
  const ms = performance.now() - t0;
  if (ms > threathold) console.log(`[resolve] ${ms.toFixed(1)}ms ${res.url}`);
  return res;
}

export async function load(url, context, next) {
  const t0 = performance.now();
  const res = await next(url, context);
  const ms = performance.now() - t0;
  if (ms > threathold) console.log(`[load] ${ms.toFixed(1)}ms ${url}`);
  return res;
}
