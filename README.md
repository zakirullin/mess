## Mess

[![Build Status](https://img.shields.io/travis/zakirullin/mess.svg?style=flat-square)](https://travis-ci.org/zakirullin/mess)
![Psalm coverage](https://shepherd.dev/github/zakirullin/mess/coverage.svg?)
![PHP from Packagist](https://img.shields.io/packagist/php-v/zakirullin/mess.svg?style=flat-square)
[![Latest Stable Version](https://poser.pugx.org/zakirullin/mess/v/stable.svg)](https://packagist.org/packages/zakirullin/mess)
![GitHub commits](https://img.shields.io/github/commits-since/zakirullin/mess/0.1.0.svg?style=flat-square)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## We face a few problems in our PHP projects

- Illogical type casting (`PHP`'s native implementation is way too "smart")
- Pointless casts like `array => float` are **allowed**
- Boilerplate code to work with arrays (check if `isset()`, throw an exception, cast the type, etc.)

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
$userId = (new Mess($queryParams))['userId']->getAsInt();
```

## Type casting with Mess is rather predictable

```php
'\d+' => int // OK
'buzz12' => int // UncastableValueException
bool => int // UncastableValueException
array => int // UncastableValueException
object => int // UncastableValueException
resource => int // UncastableValueException
```

Fairly simple, isn't it?

## Dealing with mess

```php
$queryParams = new Mess(['isDeleted' => 'true']);
$queryParams['isDeleted']->getBool(); // UnexpectedTypeException
$queryParams['isDeleted']->getAsBool(); // true

$value = new Mess('25');
$value->getInt(); // UnexpectedTypeException
$value->getAsInt(); // 25
$value->getString(); // '25'

$value = new Mess('25a');
$value->getInt(); // UnexpectedTypeException
$value->getAsInt(); // UncastableValueException

$config = new Mess(['param' => '1']);
$config['a']['b']->getInt(); // MissingKeyException: "MissingKeyException: a.b"
$config['a']['b']->findInt(); // null
$config['param']->getInt(); // UnexpectedTypeException 
$config['param']->getAsInt(); // 1
$config['param']->findInt(); // UnexpectedTypeException
$config['param']->findAsInt(); // 1
```

As you you might notice, type casting is performed while using `(find|get)As*` methods.
Having trouble grasping `get*()`/`find*()`? Check out brilliant [Ocramius's slides](https://ocramius.github.io/doctrine-best-practices/#/94).

## Installation

```bash
$ composer require zakirullin/mess
```

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
- `API` response
- Config
- etc.