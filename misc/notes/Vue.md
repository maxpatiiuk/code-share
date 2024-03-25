# Vue

My initial impressions of Vue back in 2022 where quite negative, due to it's
implicit and type-unsafe nature, and needlessly custom syntax.

I talked about this in more depth in my
[blog post on dev.to](https://dev.to/maxpatiiuk/6-big-issues-with-vuejs-3he5).

This is the notes from my 2nd look at Vue 2 years later. I was inspired to
revisit Vue because of how well Lit's templates are implemented.

## Templates

Unlike JSX, with it's wide support, close-to-JS syntax, full type-safety,
explicit behavior and flexibility, Vue is still using custom syntax

I talked about many drawbacks of their custom syntax in my blog post.

Lit has a really smart compromise between custom syntax and JSX - instead of
custom syntax (🤮), they use template literals with tagged functions. The result
is no-compilation step needed, JSX-like syntax, most features of JS supported,
and same performance benefits of Vue since string templates make it easy for the
framework to differentiate between static and dynamic parts of the template.

Given the much closer-to-JS syntax, plugins that add type-safety are simpler to
write, and more widely available (can be written as a TypeScript language server
plugin, thus works in any IDE).

Also, this custom syntax introduces a lot of needless complexity. For example,
making component generic is harder (and wasn't supported till recently).
TypeChecking is also harder (you have to hope for IDE support, or be forced to
use vue-tsc rather than the normal tsc). Same for jest, and other tools.

## Lifecycle

I like that the logic inside the component is only executed once, for
performance and memory usage reasons. Though, that does make it easy to forget
to make component reactive to every property change, where as in React,
everything is Reactive by default, unless you opt out (using useEffect)

## Reactivity

Reactivity system is very nice, and something that's not available in Lit or
React out of the box. Though, there are many standalone solutions for adding
signals to Lit or React (i.e @preactjs/signals)

## Bad practices

Just like I remember, lots of function overloads, implicit behavior,
not-type-safe behavior (or TypeScript as second-class citizen), and non-standard
syntax. Also, relies on the compiler quite a lot (a function returns different
things based on whether you destructured it's return or not 🤯).

Also, I really dislike how they flip between camelCase/PascalCase/kebab-case
(i.e you can declare some identifier in camelCase but be expected to use it in
kebab-case) - makes it hard to find references, and thus will cause bugs (for
example, directives). Lit's directives are implemented in a much more sane way -
you just call a function inside your template 😋.
