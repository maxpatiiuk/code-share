# Advanced React Notes

## Misc

Multiple inputs can use the same event handler if they have different name
attributes.

Besides just passing children, we can pass a renderProp -> a function that takes
some props and returns a JSX component:

```jsx
<Mouse>
  {({ x, y }) => (
    <p>
      {x} {y}
    </p>
  )}
</Mouse>
```

## State

Raise the state as high as it needs to go but no higher.

Besides ref, there is also a callback ref

useState can be called with a function state=>newState

## Accessibility

Use aria-\* attributes

Use HTML semantic elements

For UI overlays, both onOutsideClick and onBlur should hide the overlay

lang="{language-code}" attribute can be set for any DOM elemenet

## Good practices

Set .displayName for contexts

Use Context.Consumer JSX Element instead of React.useContext unless context's
value is needed somewhere in the code (this was changes to the context's value
only re-render the components that relay on that value)

Don't use a mutable value in Context.Provider[value] directly. Instead, use
useState

## Things to keep in mind

ErrorBoundaries does not catch errors in event handlers
