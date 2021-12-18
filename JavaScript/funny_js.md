# Funny JS

Most examples where taken directly from "You Don't Know JS", or
inspired by it.

## What would this return

```javascript
1_1..toPrecision(1)[1]
```

<details>
  <summary>Result</summary>

  ```javascript
  'e'
  ```

</details>


```javascript
070  // not in strict mode
```

<details>
  <summary>Result</summary>

  ```javascript
  56
  ```

</details>

```javascript
0O42
```

<details>
  <summary>Result</summary>

  ```javascript
  34
  ```

</details>

```javascript
JSON.parse('-0')
```

<details>
  <summary>Result</summary>

  ```javascript
  -0
  ```

</details>

```javascript
JSON.stringify(JSON.parse('-0'))
```

<details>
  <summary>Result</summary>

  ```javascript
  0
  ```

</details>

```javascript
0 !== -0
```

<details>
  <summary>Result</summary>

  ```javascript
  false
  ```

</details>

```javascript
Boolean(new Boolean(false))
```

<details>
  <summary>Result</summary>

  ```javascript
  true
  ```

</details>

```javascript
[,]
```

<details>
  <summary>Result</summary>

  ```javascript
  [empty]
  ```

</details>


```javascript
Object.getPrototypeOf((a)=>a).length
```

<details>
  <summary>Result</summary>

  ```javascript
  0
  ```

</details>


```javascript
JSON.stringify("42")
```

<details>
  <summary>Result</summary>

  ```javascript
  ""42""
  ```

</details>


```javascript
42 == [42]
```

<details>
  <summary>Result</summary>

  ```javascript
  true
  ```

</details>



## Not very well known JS features

- Reflect & Proxy
- Labels (deprecated)
- With (deprecated)
- Like `.toString()`, objects can also define `.toJSON()` that allows
  to return a ~~JSON string~~ JSON-safe value
- Similarly, there is `.toNumber()`, `.toBoolean()`
- This is a valid JS comment:
  ```javascript
  <!-- Comment -->
  ```
- Each DOM element that has an ID has a corresponding global variable
  assigned to it. (E.x, having div#main, automatically creates a `main`
  global variable pointing to that div)
- Use Object.defineProperty to assign a readonly or non iterable property

