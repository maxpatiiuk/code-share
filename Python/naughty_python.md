Just venting off on some things I don't like about Python.

# Typing syntax is bad!

- This does not do what you expect:

  ```python
  from typing import Dict, Tuple

  @dataclass
  class ClassName:
    value = Dict,
    another_value = Tuple

  ClassName(value={}, another_value=())  # ERROR!!!
  ```

- This looks ugly when compared to TypeScript:

  ```python
  a: Union[Callable[any, Dict[str,int]], bool], None]
  ```

  ```typescript
  type T = ((a: any, b: Record<string, string>) => bool) | null;
  ```

- This does not do what you expect:

  ```python
  from typing import Dict

  a = {'b':'c'}
  print(type(a) is Dict)  # FALSE!!!
  ```

- Similarly, if `a=lambda: True`, both type(a) is Callable and type(a) is
  callable are False. Instead, we have to do `callable(a)` because we have to
  confuse people!

# Dictionary syntax is bad!

- This does not do what you expect:

  ```python
  a = {
    key: "value"  # ERROR!!!
  }
  ```

  Here, `key` is assumed to be a variable, not a literal type.

  Instead, you have to do it like this

  ```python
  a = {
    "key": "value"
  }
  ```

  Why is more common case harder to read and harder to type?

  In JavaScript, it works like expected:

  ```js
  const a = {
    key: 'value',
  };
  ```

  and:

  ```js
  const key = 'key_value';
  const a = {
    [key]: 'value',
  };
  ```

  Plus, in JS you have Symbols!

# Lambda syntax is bad!

- Why can't I have multiple statements in a single lambda function? In JS I
  wrote some super beautiful lambda functions. Heck, most of my functions were
  lambdas.

# Are you telling me Python didn't have a dataclass till 3.7?

And named tuples aren't much better. NamedTuples don't even work properly with
`json.dumps()` or print()

# f-Strings....f\*ck-them

- First, f"" is uglier than minimalistic \`\` in JS
- Secondly, I can't span multiple lines, unlike in JS
- Thirdly, good luck printing literal `{` and `}` inside of f-Strings. You wound
  end up with something as ugly as this:

  ```
  f"{'{'}a{'}'}"
  ```

  Where as in JS it is just:

  ```
  `{a}`
  ```

- Finally, and worse of all, I can't reuse the same quotes inside of f-strings!
  That's like the works thing ever. Escaping doesn't work either. Seriously???

# Spread syntax is bad!

- Why do I have to do this `[*list]` for lists and this `{**dict}` for
  dictionaries?. Why can't it be the same syntax for both?

  This seems more reasonable: `[...list]`, `{...dict}`

# Syntax is confusing!

- Someone please explain to me when I have to use '\' in multi line statements
  because I am not smart enough to understand it.

  Same goes for ("writing" "strings" "without" "commas")

# Syntax is bad!

- WTF is ''.join(['1','2','3']) ???

  ```python
  ' who? '.join(['though','that','this','is','a','good','idea'])
  ```

- Why, oh, why do I have to put `:` at the end of if/else statements?

- I can't do `else if`? Seriously? Do you think `elif` is better?

  Did they choose it because of brevity? Then why don't they choose `elf` -
  seems even briefer, but just as confusing.

# Performance

Well, Python is slower than Node, so there isn't much to talk about here...
