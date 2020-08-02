# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [0.5.3] - 2020-08-02
### Removed
- 'true' & 'false' to bool casting

## [0.5.1] - 2020-08-01
### Added
- `getArrayOfStringToMixed()`
- `findArrayOfStringToMixed()`

## [0.5.0] - 2020-08-01
### Added
- It is Mess now 🍺

## [0.4.0] - 2020-08-01
### Removed
- `TypedAccessor` (deprecated, use `Mess` instead)

## [0.3.1] - 2020-08-01
### Added
- `Mess` alias (can be used instead long and boring `TypedAccessor`)
- more tests

## [0.3.0] - 2020-08-01
### Added
- `getObject()`
- `getArray()`
- `getArrayOfStringToInt()`
- `getArrayOfStringToBool()`
- `getArrayOfStringToString()`

### Fix
- static classes instead of stateless type objects
- separate finder classes
- type asserts 

## [0.2.1] - 2020-07-18
### Fix
- Psalm warnings (errorLevel="1")

## [0.2.0] - 2020-07-17
### Added
- Separate type classes
- List types

## [0.1.0] - 2020-05-21
### Added
- Initial release