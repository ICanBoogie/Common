# Common 

[![Release](https://img.shields.io/packagist/v/ICanBoogie/Common.svg)](https://packagist.org/packages/ICanBoogie/Common/releases)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Common/master.svg)](http://travis-ci.org/ICanBoogie/Common)
[![HHVM](https://img.shields.io/hhvm/icanboogie/common.svg)](http://hhvm.h4cc.de/package/icanboogie/common)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Common/master.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Common)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Common/master.svg)](https://coveralls.io/r/ICanBoogie/Common)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/common.svg)](https://packagist.org/packages/icanboogie/common)

This package provides basic classes and helpers shared by many [ICanBoogie][]
packages. It provides offset exceptions, property exceptions, some interfaces, and helpers to
transform strings and arrays.





## Exceptions

### Offset exceptions

The following exceptions related to array offset are defined by the package:

* [OffsetError][]: Exception thrown when there is something wrong with an array offset.
* [OffsetNotDefined][]: Exception thrown when an array offset is not defined.
* [OffsetNotReadable][]: Exception thrown when an array offset is not readable.
* [OffsetNotWritable][]: Exception thrown when an array offset is not writable.





### Property exceptions

The following exceptions related to object properties defined by the package:

* [PropertyError](http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyError.html): Exception thrown when there is something wrong with an object property.
* [PropertyNotDefined](http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotDefined.html): Exception thrown when a property is not defined.
* [PropertyNotReadable](http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotReadable.html): Exception thrown when a property is not readable.
* [PropertyNotWritable](http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotWritable.html): Exception thrown when a property is not writable.

```php
<?php

use ICanBoogie\PropertyNotDefined;

class A
{
	private $id;

	public function __get($property)
	{
		if ($property == 'id')
		{
			return $this->id;
		}

		throw new PropertyNotDefined(array($property, $this));
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
	public function to_array()
	{
		return (array) $this;
	}

	public function to_array_recursive()
	{
		$array = $this->to_array();

		foreach ($array as $key => &$value)
		{
			if ($value instanceof ToArrayRecursive)
			{
				$value = $value->to_array_recursive();
			}
			else if ($value instanceof ToArray)
			{
				$value = $value->to_array();
			}
		}

		return $array;
	}
}
```





## Traits

For PHP5.4 users, the [ToArrayRecursiveTrait][] trait can be used to define
the `to_array_recursive()` method.

```php
<?php

use ICanBoogie\ToArray;
use ICanBoogie\ToArrayRecursive;

class A implements ToArrayRecursive
{
	use ToArrayRecursiveTrait;

	public function to_array()
	{
		return (array) $this;
	}
}
```





----------

## Requirement

The package requires PHP 5.3 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/).
Create a `composer.json` file and run `php composer.phar install` command to install it:

```
$ composer require icanboogie/common
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/Common), its repository can be
cloned with the following command line:

	$ git clone git://github.com/ICanBoogie/Common.git





## Documentation

The package is documented as part of the [ICanBoogie][] framework
[documentation][]. You can generate the documentation for the package
and its dependencies with the `make doc` command. The documentation is generated in the `docs`
directory. [ApiGen](http://apigen.org/) is required. You can later clean the directory with
the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all dependencies required to run the suite. You can later
clean the directory with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/Common/master.svg)](http://travis-ci.org/ICanBoogie/Common)





## License

**icanboogie/common** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[documentation]:         http://api.icanboogie.org/common/1.2/
[OffsetError]:           http://api.icanboogie.org/common/1.2/class-ICanBoogie.OffsetError.html
[OffsetNotDefined]:      http://api.icanboogie.org/common/1.2/class-ICanBoogie.OffsetNotDefined.html
[OffsetNotReadable]:     http://api.icanboogie.org/common/1.2/class-ICanBoogie.OffsetNotReadable.html
[OffsetNotWritable]:     http://api.icanboogie.org/common/1.2/class-ICanBoogie.OffsetNotWritable.html
[PropertyError]:         http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyError.html
[PropertyNotDefined]:    http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotDefined.html
[PropertyNotReadable]:   http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotReadable.html
[PropertyNotWritable]:   http://api.icanboogie.org/common/1.2/class-ICanBoogie.PropertyNotWritable.html
[ToArray]:               http://api.icanboogie.org/common/1.2/class-ICanBoogie.ToArray.html
[ToArrayRecursive]:      http://api.icanboogie.org/common/1.2/class-ICanBoogie.ToArrayRecursive.html
[ToArrayRecursiveTrait]: http://api.icanboogie.org/common/1.2/class-ICanBoogie.ToArrayRecursiveTrait.html
[ICanBoogie]:            http://icanboogie.org/
