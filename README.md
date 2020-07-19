## We face a few problems in PHP projects

- Illogical type casting (`PHP`'s native implementation is way too "smart")
- Pointless casts like `array => float` are **allowed**
- Arrays & boilerplate code to work with them (check if `isset()`, throw an exception, cast the type, etc.)

Consider an example:
```php
$userId = $queryParams['userId'] ?? null;
if ($userId === null) {
    throw new BadRequestException();
}
$userId = (int)$userId;
```

## Way too verbose. Any ideas?

```php
$userId = (new TypedAccessor($queryParams))['userId']->getAsInt();
```

## A few real-world examples

```php
$queryParams = new TypedAccessor(['isDeleted' => 'true']);
$queryParams['isDeleted']->getBool(); // UnexpectedTypeException
$queryParams['isDeleted']->getAsBool(); // true

$value = new TypedAccessor('25');
$value->getInt(); // UnexpectedTypeException
$value->getAsInt(); // 25
$value->getString(); // '25'

$value = new TypedAccessor('abc');
$value->getInt(); // UnexpectedTypeException
$value->getAsInt(); // UncastableValueException
$value->findInt(); // null
$value->findInt() ?? 1; // 1

$config = new TypedAccessor(['param' => '1']);
$config['a']['b']->getInt(); // MissingKeyException: "MissingKeyException: a.b"
$config['a']->findInt(); // null
$config['param']->getInt(); // UnexpectedTypeException 
$config['param']->getAsInt(); // 1
$config['param']->findInt(); // null
$config['param']->findAsInt(); // 1
```

As you you might notice, no type casting is performed when using `get*()` methods.
Having trouble grasping `get*()`/`find*()`? Check out brilliant [Ocramius's slides](https://ocramius.github.io/doctrine-best-practices/#/94).

## Type casting now is rather predictable

```php
'\d+' => int // OK`
'buzz12' => int // UncastableValueException
bool => int // UncastableValueException
array => int // UncastableValueException
object => int // UncastableValueException
resource => int // UncastableValueException
```

Fairly simple, isn't it?

### Why one needs THAT naive type casting?

Let's imagine a library that is configured that way:
```php
$config = [
    'retries' => 5, // int
    'delay' => 20, // int
]

// Initialization 
$retries = $config['retries'] ?? null;
if ($retries === null) {
    throw new MissingConfigKeyException(...);
}
...
$retries = (int)$retries;
$delay = (int)$delay;
```

Client-side code: 
```php
$config => [
    'retries' => [5, 10, 30], // (int)array => 1
    'delay' => true, // (int)bool => 1
]
```

No matter if that's a misuse or a result of major update: The system will continue to work.
And that's the worst thing about it. It will continue to work, though, not in a way it was supposed to work.
`PHP` is trying to do its best to let it work **at least somehow**.

## The library comes in handy in a variety of scenarios 🚀

- Deserialized data
- Request `body`/`query` 
- `API` responses
- etc.

```bash
$ composer require zakirullin/typed-accessor
```
