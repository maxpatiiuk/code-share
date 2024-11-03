# Lit

Notes about Lit. Mainly focusing on how Lit compares to Stencil

## Impressions

TLDR: everything in Lit is optimized about not requiring a build step. This
results in intreating tradeoffs. The side-effect of that is that most behavior
of Lit is customizable/overwrite at runtime, rather than constrained by a static
compiler - that gives much more freedom in cases when it's necessary.

Lit also chose to provide much more flexibility in all places: lifecycle
methods, render mechanism, events, props.

The no-compiler approach creates some tradeoffs, but these seem like smart
trade-offs. Though, without playing around with Lit for considerable time, it's
hard to say what "gotchas" there might be hidden - the official docs don't
always mention all the limitations and drawbacks of a given framework (just like
Stencil's docs are conspicuously silent on composition).

### General

- Very similar API to Stencil, given that both are based on web components.
  Though, Lit is closer to the web platform (can be used even without a
  compiler). Lit also implements pretty much all features of Stencil and much
  more, so can be loosely considered to be a superset of Stencil

  - It also leaves you to do some things on your own (like
    [adding TypeScript typings for your library](https://lit.dev/docs/components/defining/#typescript-typings),
    or
    [creating React wrappers](https://lit.dev/docs/frameworks/react/#createcomponent))

  - Lit has no lazy loading, and does not have separate output
    targets - you are on your own for that (and for docs too)

  - Lit's lifecycle methods are just methods defined on the base class - can be
    extended/have some code executed before or after if needed. Much simpler
    than with the AST manipulation that Stencil does (and it's limitations)

    - [Reactive Lifecycle](https://lit.dev/docs/components/lifecycle/#reactive-update-cycle).
      More lifecycle methods than in Stencil, but that could be a foot gun. You
      can even customize the scheduling of DOM updates

- 👍👍👍 You can extend your component from your own base class. Take that
  Stencil!

- While I'm not a fun on using strings over JSX, they have some advantages:

  - Lit knows what parts of the markup are static and what dynamic, thus
    improving performance by reducing the need for diffing
  - much more flexible than JSX, with support for DOM elements, many built-in
    directives and custom directives (even async!)
  - no compilation step required

  And with [lit plugins](https://lit.dev/docs/tools/development/#ide-plugins)
  for VSCode and TypeScript, string templates aren't that bad. In summary, this
  is not that different from Vue's template.

  Though, they don't natively support the spread syntax like JSX does
  (utils for this exist though)

- With a large company like Google behind Lit, and using Lit internally, I won't
  be worried about them disappearing for a few years, or not having basic
  features like source map support (Stencil didn't have it till a few years ago)
  or composition

- Interestingly, they recommend
  [against .css files](https://lit.dev/docs/components/styles/#external-stylesheet)
  and recommend using their `styles = css\`:host { }\`` syntax instead. Though
  the reasons they give are not applicable when using a bundler (like in
  Stencil)

- Has experimental SSR support

- 👍 The compatibility with Maps SDK's view.ui is easier in Lit as you can
  [tell Lit to render the contents of the component outside the component](https://lit.dev/docs/components/shadow-dom/#implementing-createrenderroot)

### Props/attributes

- This declares a property in Lit, which looks identical to the Accessor in
  ArcGIS Maps SDK for JavaScript:

  ```ts
  @property({type: String})
  mode?: string;
  ```

- 👍 Can provide a `converter` object/function to `@property` for
  (de)serialization

- 👍 Can provide a `hasChanged` function to `@property` to determine if old and
  new value are equivalent (rather than using default strict equality)

- 👎 Can provide a custom html `attribute` name. Interesting that the default is
  `lowercase` rather than `kebab-case` - closer to the HTML attribute naming
  convention, but less readable

  - 👍  Fortunately, I was able to patch that - everything in Lit is easily
    patchable compared to Stencil

- 👎 Numbers set as HTML attributes are not automatically converted but remain a
  string, unless `{type: Number}` is set:

  ```ts
  @property({ type: Number })
  count: number = 0;
  ```

  (in Stencil, this happens automatically when compiler sees that the property's
  TypeScript type is `number`)

- 👍 Interesting Point on Boolean attributes:

  > For a boolean property to be configurable from an attribute, it must default
  > to false. If it defaults to true, you cannot set it to false from markup,
  > since the presence of the attribute, with or without a value, equates to
  > true. This is the standard behavior for attributes in the web platform.
  >
  > If this behavior doesn't fit your use case, there are a couple of options:
  >
  > - Change the property name so it defaults to false. For example, the web
  >   platform uses the disabled attribute (defaults to false), not enabled.
  > - Use a string-valued or number-valued attribute instead.

- 👍 Mentions that reflecting props would be less necessary once this spec is
  finalized: https://wicg.github.io/custom-state-pseudo-class/

- 👍👍👍 Get/Set supported. Take that Stencil!

  - Though they correctly recommend using lifecycle hooks instead in some cases
    for better performance (when setter is modifying another property)

- 👍👍👍 Custom decorators are supported. Take that Stencil!

### Events

- Emitting events uses native `.dispatchEvent()` API.

  - 👍 very flexible and composable
  - 👎 can't auto-generate docs for events.

    - edit: that's not true. you can document that using
      [`Custom Elements Manifest`](https://custom-elements-manifest.open-wc.org/analyzer/getting-started/),
      which lit supports very well.

- Useful advice:

  > Events should be dispatched in response to user interaction or asynchronous
  > changes in the component's state. They should generally not be dispatched in
  > response to state changes made by the owner of the component via its
  > property or attribute APIs. This is generally how native web platform
  > elements work.
  >
  > For example, when a user types a value into an input element a change event
  > is dispatched, but if code sets the input's value property, a change event
  > is not dispatched.

- 👍 Can
  [create custom event classes](https://lit.dev/docs/components/events/#standard-custom-events)
  (like a map click event) thanks to Lit being so close to the web platform

### Misc

- 👍👍👍 Really like the implementation of reactive controllers, built-in
  directives and custom-directives - very powerful and flexible, while being
  quite type-safe

  - Fun fact: in Stencil, I had to come up with a pattern I called "Controllers"
    for reusing logic across components. At the time, I had no idea that Lit had
    the same feature, let alone that it would be called by the same name! 😂

    - In fact, Lit's controllers can be used in Stencil components if we would
      need to (for example, Lit's context library is implemented using Lit's
      controllers). This is because Lit's APIs are close to the web platform,
      and don't have a lock in, unlike Stencil's

  - This is just so cool:

    ```ts
    class MyElement extends LitElement {
      private _textSize = new ResizeController(this);

      render() {
        return html`
          <textarea ${this._textSize.observe()}></textarea>
          <p>The width is ${this._textSize.contentRect?.width}</p>
        `;
      }
    }
    ```