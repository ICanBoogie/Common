# Common

[![Release](https://img.shields.io/packagist/v/icanboogie/common.svg)](https://packagist.org/packages/icanboogie/common)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Common/badge.svg?branch=main)](https://coveralls.io/r/ICanBoogie/Common?branch=main)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/common.svg)](https://packagist.org/packages/icanboogie/common)

This package provides basic classes and helpers shared by many [ICanBoogie][]
packages. It provides offset exceptions, property exceptions, some interfaces,
and helpers to transform strings and arrays.

#### Installation

```shell
composer require icanboogie/common
```



## Exceptions

### Offset exceptions

The package defines the following exceptions related to array offset:

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

The package defines the following interfaces:

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

[![Tests](https://github.com/ICanBoogie/Common/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/ICanBoogie/Common/actions/workflows/test.yml)
[![Static Analysis](https://github.com/ICanBoogie/Common/actions/workflows/static-analysis.yml/badge.svg?branch=main)](https://github.com/ICanBoogie/Common/actions/workflows/static-analysis.yml)
[![Code Style](https://github.com/ICanBoogie/Common/actions/workflows/code-style.yml/badge.svg?branch=main)](https://github.com/ICanBoogie/Common/actions/workflows/code-style.yml)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you're expected to uphold this code.



## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for details.



[OffsetError]:           lib/OffsetError.php
[OffsetNotDefined]:      lib/OffsetNotDefined.php
[OffsetNotReadable]:     lib/OffsetNotReadable.php
[OffsetNotWritable]:     lib/OffsetNotWritable.php
[PropertyError]:         lib/PropertyError.php
[PropertyNotDefined]:    lib/PropertyNotDefined.php
[PropertyNotReadable]:   lib/PropertyNotReadable.php
[PropertyNotWritable]:   lib/PropertyNotWritable.php
[ToArray]:               lib/ToArray.php
[ToArrayRecursive]:      lib/ToArrayRecursive.php
[ToArrayRecursiveTrait]: lib/ToArrayRecursiveTrait.php
[ICanBoogie]:            https://icanboogie.org/
