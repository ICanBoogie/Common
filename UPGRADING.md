# Upgrade Guide

## 1.x to 2.0

- The package requires PHP 7.1+
- `OffsetError` and `PropertyError` are now interfaces, better use one of the other classes or implement your own.
- The `$code` parameter has been removed from all exceptions. `getCode()` should return `0`.
- Types have been updated everywhere, this might clash with your implementations of the interfaces.
