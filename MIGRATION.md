# Migration

## v2.x to v6.0

### New Requirements

- PHP 8.1+

### New features

- Added `iterable_to_dictionary()` to transform an iterable into a dictionary.

### Backward Incompatible Changes

None

### Deprecated Features

- `stable_sort()` since PHP 8.0, [sorting is stable](https://wiki.php.net/rfc/stable_sorting), use `asort()` or `uasort()` instead.

### Other Changes

None
