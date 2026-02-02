# Astro

## Pros

### Great docs

Very good and beginner friendly docs. There are some unintuitive TypeScript or
Vite behaviors, that Astro's docs explain better than I could.

### Friendlier SSR

Avoids SSR hydration issues by rendering components only on the server by
default.

### Micro-frontend friendly

Ability to mix multiple frameworks easily in the same app is a great value
proposition for larger enterprise teams.

The fact that framework's code is not even shipped by the client by default
makes this even better.

### TypeScript by default

The starter uses tsconfig.json out of the box.

They also use stricter TypeScript setting by default, including the recently
introduced `verbatimModuleSyntax`

Though, they don't use `astro.config.ts` by default yet.

### Uses standard SEO meta tags

Instead of introducing custom SEO configuration concepts, it relies on the
standard `<meta>` and `<link>` tags. You can reuse these tags by creating layout
components.

### Built-in dev toolbar

Has nice shortcuts, and is extensible.

As a positive surprise, they have a built-in accessibility scanner, which is a
good for the industry.

## Cons

### Custom .astro file format

I have a big issue with making up yet another domain specific language.

`.astro` could have been just `.tsx`. See Fresh, React, Preact, Solid, Qwik.

It is yet another file format to learn. And a lot more tooling complexity:

- Custom Prettier parser
- Custom ESLint parser
- Custom TypeScript language server
- `npx tsc` doesn't work - you are locked into `astro check`
- Custom VSCode plugin
- If you linter or IDE is not supported, you are out of luck

They try to position this file as just HTML with extra features. This is a
misleading lie:

- `<script>` is not built-in script, but Astro's magic. It is quite bad for the
  ecosystem that Astro doesn't require explicit `type="module"`, like Vite does.
- `<style>` is not regular style, but a leaky scoping magic. Its not shadow dom
  either. It adds custom concepts like `is:global` and `:global()`.
- `<slot>` is Astro slot, not HTML slot. You need to use `is:inline` for regular
  behavior. I would rather they have used `<Slot />` or `<AstroSlot />`.

Astro's templating syntax is not HTML. It is yet another JSX variation.

One place where Astro could have advanced the status quo, but didn't is in where
their JSX typing comes from. Rather than shipping custom JSX types, like React
and Preact, they could have reused standard DOM types, at least for custom
elements. Instead, every web component library has to ship custom JSX types for
React, Preact, Vue, and now Astro too.

`.tsx` file is less magic, less abstraction, and more TypeScript friendly. You
have an explicit function, with strictly typed props (including children props).

The need to support custom integration for all tooling is a maintenance concern.
We will see if Astro's team keeps up with updating these. At the time of
writing, Vite 8 is in beta, but Astro is still on Vite 6.

### Too many Astro-specific concepts

`.env` file handling is misaligned with built-in JavaScript and TypeScript
concepts. Then, they had to bolt-on type checking using a custom schema
language. This could have just been a `config.production.ts` file that uses
regular JavaScript spread, and TypeScript types:

```ts
import { config as baseConfig } from './config.ts';

export const config = {
  ...config,
  apiKey: '...',
};
```

Custom view transitions API, custom internationalization API, and custom link
prefetching API is too much too. Feels like Next.js all over.

I would have loved for Astro to be just a Vite plugin, like `useAstro()`, with
bare minimum custom concepts, and without any `astro check` CLIs.

### Lacks `onClick` props

Promoting `document.querySelector().addEventListener` is a step backwards for
ergonomics and memory leaks prevention.

Event listening using `onClick` is declarative, type-safe, and avoids leaking
listeners.

It is a concept used by practically every templating framework. Even lit-html,
which prides itself on being close to the DOM, uses such concept.
