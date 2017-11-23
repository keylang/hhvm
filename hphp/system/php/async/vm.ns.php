<?hh

// These are in a separate file so they can be loaded before the things that
// use them

namespace HH\Asio {

/**
 * Translate a `KeyedTraversable` of `Awaitables` into a single `Awaitable of
 * `Map`.
 *
 * This function takes any `KeyedTraversable` object of `Awaitables` (i.e.,
 * each member of the `KeyedTraversable` has a value of type of `Awaitable`,
 * likely from a call to a function that returned `Awaitable<T>`), and
 * transforms those `Awaitables` into one big `Awaitable` `Map`.
 *
 * This function is called `m` because we are returning a `m`ap of `Awaitable`.
 *
 * Only When you `await` or `join` the resulting `Awaitable`, will all of the
 * key/values in the `Map` within the returned `Awaitable` be available.
 *
 * @deprecated use `Dict\from_async()` instead.
 *
 * @param $awaitables - The collection of `KeyedTraversable` awaitables.
 *
 * @return - An `Awaitable` of `Map`, where the `Map` was generated from
 *           each `KeyedTraversable` member in `$awaitables`.
 */
async function m<Tk, Tv>(
  KeyedTraversable<Tk, Awaitable<Tv>> $awaitables,
): Awaitable<Map<Tk, Tv>> {
  $wait_handles = Map {};
  foreach ($awaitables as $index => $awaitable) {
    $wait_handles[$index] = $awaitable->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromMap($wait_handles);
  // TODO: When systemlib supports closures
  // return $wait_handles->map($o ==> $o->result());
  $ret = Map {};
  foreach($wait_handles as $key => $value) {
    $ret[$key] = \HH\Asio\result($value);
  }
  return $ret;
}

/**
 * Translate a `Traversable` of `Awaitables` into a single `Awaitable` of
 * `Vector`.
 *
 * This function takes any `Traversable` object of `Awaitables` (i.e., each
 * member of the `Traversable` is of type of `Awaitable`, likely from a call
 * to a function that returned `Awaitable<T>`), and transforms those
 * `Awaitables` into one big `Awaitable` `Vector`.
 *
 * This function is called `v` we are returning a `v`ector of `Awaitable`.
 *
 * Only When you `await` or `join` the resulting `Awaitable`, will all of the
 * values in the `Vector` within the returned `Awaitable` be available.
 *
 * @deprecated use `Vec\from_async()` instead.
 *
 * @param $awaitables - The collection of `Traversable` awaitables.
 *
 * @return - An `Awaitable` of `Vector`, where the `Vector` was generated from
 *           each `Traversable` member in `$awaitables`.
 */
async function v<Tv>(
  Traversable<Awaitable<Tv>> $awaitables,
): Awaitable<Vector<Tv>> {
  $wait_handles = Vector {};
  $wait_handles->reserve(count($awaitables));
  foreach ($awaitables as $awaitable) {
    $wait_handles[] = $awaitable->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromVector($wait_handles);
  // TODO: When systemlib supports closures
  // return $wait_handles->map($o ==> $o->result());
  $ret = Vector {};
  foreach($wait_handles as $value) {
    $ret[] = \HH\Asio\result($value);
  }
  return $ret;
}

/**
 * Translate a varargs of `Awaitable`s into a single `Awaitable<(...)>`.
 * This function's behavior cannot be expressed with type hints,
 * so it's hardcoded in the typechecker:
 *
 *     HH\Asio\va(Awaitable<T1>, Awaitable<T2>, ... , Awaitable<Tn>)
 *
 * will return
 *
 *     Awaitable<(T1, T2, ..., Tn)>
 *
 * @deprecated Use `Tuple\from_async()` instead.
 * @fbdeprecated Use `genva()` instead.
 */
async function va(...$args): Awaitable/*<(...)>*/ {
  $wait_handles = array();
  foreach ($args as $value) {
    $wait_handles[] = $value->getWaitHandle();
  }
  await AwaitAllWaitHandle::fromArray($wait_handles);
  $ret = array();
  foreach ($wait_handles as $value) {
    $ret[] = \HH\Asio\result($value);
  }
  return $ret;
}

} // namespace HH\Asio
