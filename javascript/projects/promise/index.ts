type State = 'pending' | 'fulfilled' | 'rejected';

class Async<T> {
  public constructor(
    callback: (
      resolve: (value: T | Async<T>) => void,
      reject: (error?: unknown) => void
    ) => void
  ) {
    if (typeof callback !== 'function')
      throw new Error('callback is not a function');

    const resolve = (value: T | Async<T>): void => {
      if (this._state !== 'pending') return;
      Async._unwrap(
        value,
        (value) => {
          this._value = value;
          this._state = 'fulfilled';
        },
        reject
      );
    };
    const reject = (error?: unknown): void => {
      if (this._state !== 'pending') return;
      this._error = error;
      this._state = 'rejected';
    };

    try {
      callback(resolve, reject);
    } catch (error) {
      reject(error);
    }
  }

  public get state(): State {
    return this._state;
  }

  private __state: State = 'pending';
  private get _state(): State {
    return this.__state;
  }
  private set _state(state: State) {
    this.__state = state;
    this._stateChangeListeners.forEach((listener) => listener());
    // Prevent memory leaks
    this._stateChangeListeners = [];
  }

  private _stateChangeListeners: Array<() => void> = [];
  private _onAfterResolved(callback: () => void) {
    if (this._state === 'pending') this._stateChangeListeners.push(callback);
    else queueMicrotask(callback);
  }

  private _value?: T;
  private _error?: unknown;

  public static resolve(): Async<void>;
  public static resolve<U>(value: U): Async<U>;
  public static resolve<U>(value?: U): Async<U> {
    return new Async((resolve) => resolve((value ?? undefined) as U));
  }

  public static reject(error?: unknown): Async<never> {
    return new Async((_resolve, reject) => reject(error));
  }

  public then<U, U2 = never>(
    callback?: (value: T) => U | Async<U>,
    errorCallback?: (error: unknown) => U2 | Async<U2>
  ): Async<U | U2> {
    return new Async((resolve, reject) =>
      this._onAfterResolved(() => {
        if (this._state === 'fulfilled') {
          const value =
            typeof callback === 'function'
              ? callback(this._value!)
              : (this._value as U);
          Async._unwrap(value, resolve, reject);
        } else if (typeof errorCallback === 'function') {
          const value = errorCallback(this._error);
          Async._unwrap(value, resolve, reject);
        } else reject(this._error);
      })
    );
  }

  public catch<U>(
    errorCallback: (error: unknown) => U | Async<U>
  ): Async<U | T> {
    return this.then(undefined, errorCallback);
  }

  public finally(doneCallback: () => void): Async<T> {
    if (typeof doneCallback !== 'function')
      throw new Error('callback is not a function');
    return new Async((resolve) => {
      this._onAfterResolved(() => {
        doneCallback();
        resolve(this);
      });
    });
  }

  private static _unwrap<U>(
    value: U | Async<U>,
    callback: (value: Awaited<U>) => void,
    errorCallback: (error: unknown) => void
  ): void {
    if (value instanceof Async)
      value
        .then((value) => Async._unwrap(value, callback, errorCallback))
        .catch(errorCallback);
    else callback(value as Awaited<U>);
  }
}

// The Async API matches Promise API:
new Async((resolve) => resolve(1));

new Async((_resolve, reject) => reject(2));

new Async(() => {
  throw new Error('a');
})
  .then(console.log, console.error)
  .catch(console.error)
  .finally(() => console.trace('Complete'));

Async.resolve(1);
Async.reject(1);

const a = new Async((resolve) => resolve(Async.resolve('a')));

Async.resolve('a').then(
  () => new Async((resolve) => resolve(Async.resolve('b')))
);
