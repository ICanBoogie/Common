# Common

[![Release](https://img.shields.io/packagist/v/icanboogie/common.svg)](https://packagist.org/packages/icanboogie/common)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Common.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Common)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Common.svg)](https://coveralls.io/r/ICanBoogie/Common)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/common.svg)](https://packagist.org/packages/icanboogie/common)

This package provides basic classes and helpers shared by many [ICanBoogie][]
packages. It provides offset exceptions, property exceptions, some interfaces, and helpers to
transform strings and arrays.

#### Installation

```bash
composer require icanboogie/common
```



## Exceptions

### Offset exceptions

The following exceptions related to array offset are defined by the package:

* [OffsetError][]: Interface for offset errors.
* [OffsetNotDefined][]: Exception thrown when an array offset is not defined.
* [OffsetNotReadable][]: Exception thrown when an array offset is not readable.
* [OffsetNotWritable][]: Exception thrown when an array offset is not writable.



### Property exceptions

The following exceptions related to object properties defined by the package:

* [PropertyError][]: Interface for property errors.
* [PropertyNotDefined][]: Exception thrown when a property is not defined.
* [PropertyNotReadable][]: Exception thrown when a property is not readable.
* [PropertyNotWritable][]: Exception thrown when a property is not writable.

```php
<?php

use ICanBoogie\PropertyNotDefined;

class A
{
	private $id;

	public function __get(string $property)
	{
		if ($property === 'id') {
			return $this->id;
		}

		throw new PropertyNotDefined([ $property, $this ]);
	}
}
```



## Interfaces

The following interfaces are defined by the package:

- [ToArray][]: Should be implemented by classes whose instances can be converted into arrays.
- [ToArrayRecursive][]: Should be implemented by classes whose instances can be converted into
arrays recursively.

```php
<?php

use ICanBoogie\ToArray;
use ICanBoogie\ToArrayRecursive;

class A implements ToArrayRecursive
{
	use ToArrayRecursiveTrait;

	public function to_array(): array
	{
		return (array) $this;
	}
}
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/Common/actions).

[![Tests](https://github.com/ICanBoogie/Common/workflows/test/badge.svg?branch=master)](https://github.com/ICanBoogie/master/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/Common/workflows/static-analysis/badge.svg?branch=master)](https://github.com/ICanBoogie/Common/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/Common/workflows/code-style/badge.svg?branch=master)](https://github.com/ICanBoogie/Common/actions?query=workflow%3Acode-style)



## Testing

We provide a Docker container for local development. Run `make test-container` to create a new session. Inside the
container run `make test` to run the test suite. Alternatively, run `make test-coverage` for a breakdown of the code
coverage. The coverage report is available in `build/coverage/index.html`.



## License

**icanboogie/common** is released under the [BSD-3-Clause](LICENSE).



[documentation]:         https://icanboogie.org/api/common/1.2/
[OffsetError]:           https://icanboogie.org/api/common/1.2/class-ICanBoogie.OffsetError.html
[OffsetNotDefined]:      https://icanboogie.org/api/common/1.2/class-ICanBoogie.OffsetNotDefined.html
[OffsetNotReadable]:     https://icanboogie.org/api/common/1.2/class-ICanBoogie.OffsetNotReadable.html
[OffsetNotWritable]:     https://icanboogie.org/api/common/1.2/class-ICanBoogie.OffsetNotWritable.html
[PropertyError]:         https://icanboogie.org/api/common/1.2/class-ICanBoogie.PropertyError.html
[PropertyNotDefined]:    https://icanboogie.org/api/common/1.2/class-ICanBoogie.PropertyNotDefined.html
[PropertyNotReadable]:   https://icanboogie.org/api/common/1.2/class-ICanBoogie.PropertyNotReadable.html
[PropertyNotWritable]:   https://icanboogie.org/api/common/1.2/class-ICanBoogie.PropertyNotWritable.html
[ToArray]:               https://icanboogie.org/api/common/1.2/class-ICanBoogie.ToArray.html
[ToArrayRecursive]:      https://icanboogie.org/api/common/1.2/class-ICanBoogie.ToArrayRecursive.html
[ToArrayRecursiveTrait]: https://icanboogie.org/api/common/1.2/class-ICanBoogie.ToArrayRecursiveTrait.html
[ICanBoogie]:            https://icanboogie.org/
