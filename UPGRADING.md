# Upgrade Guide

## 2.x to 6.0

- `FormattedString` only works with array arguments. Since keys can be used as pattern references, better have the same interface whatever the usage.

    ```php
    new FormatterString("Hello {0}!", "Olivier");
    ```
    ```php
    new FormatterString("Hello {0}!", [ "Olivier" ]);
    ```

## 1.x to 2.0

- The package requires PHP 7.1+
- `OffsetError` and `PropertyError` are now interfaces, better use one of the other classes or implement your own.
- The `$code` parameter has been removed from all exceptions. `getCode()` should return `0`.
- Types have been updated everywhere, this might clash with your implementations of the interfaces.
