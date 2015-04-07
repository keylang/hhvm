<?hh // strict
class FooBase {}
class Foo extends FooBase {}
class FooDerived extends Foo {}
function bar<Tx super Tx1, Tx1 super Ty, Ty as Ty1, Ty1>(
  Ty $val,
  Tx $dummy,
): Tx {
  return $val;
}
function test(FooBase $foo_base, FooDerived $foo_derived): void {
  bar($foo_derived, $foo_base);
}
