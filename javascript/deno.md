# Deno

## General

They are trying to be a lot like Go - integrated tooling, standard library.
Nice, but more integration with the rest of the ecosystem would be nicer. I
don't feel like I would want to use Deno in a personal project because if I come
back to it later, won't remember how Deno works anymore, and the project won't
be compatible with Node.js. I could see using Deno if it was adopted at my
workspace, but otherwise, I would prefer more community-standard compatible
tooling.

## Compatibility

Don't like that they are quite not backward compatible with the rest of the
ecosystem. They basically created their own tooling for most popular things in
the ecosystem, which does create nice integration, but also lock in. The Vite
approach is much better - building on top of the community, being compatible
with practically everything, doing lots of things for you auto-magically and
being very composable with other things (Vitest, VitePress, Vue, vite-node...) -
in addition to the OXC ecosystem that Vite is adding integrations with.

Not sure I like that linting, formatting, testing and type checking is
configured in the same file - if I want to run `tsc` standalone, it won't fine
the configuration anymore? And none of the other IDE plugins or tooling would
work out of the box either.

Their test runner is basic. Their linter is basic. Their formatter is comparable
to prettier.

I do like though the adoption of Web APIs - though Node.js is catching up too.
Built in TypeScript integration is great, but Node.js is catching up too.

## Security

Like the security model, though would be nice to have a way to see "here are all
the permissions this script needs - agree?" - and be notified when those
permissions change.

## Features

### Imports

I think the HTTPs import and version numbers in the import specifiers should be
a hacky backdoor for tiny scripts rather than emphasized heavily in the docs.
It's not maintainable, and looks very verbose.

### Runnable docs

Neat idea, if the tooling support is great. Otherwise, more conventional test
files with language server integrations for inline doc hints would be better.
