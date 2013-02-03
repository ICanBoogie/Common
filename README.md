# Common [![Build Status](https://secure.travis-ci.org/ICanBoogie/Common.png?branch=master)](http://travis-ci.org/ICanBoogie/Common)

This package provides the basic classes and helpers shared by all [ICanBoogie](http://icanboogie.org/)
packages. It includes offset exceptions, property exceptions, and helpers to transform strings
and arrays.





## Requirement

The package requires PHP 5.3 or later.





## Installation

The recommended way to install this package is through [composer](http://getcomposer.org/).
Create a `composer.json` file and run `php composer.phar install` command to install it:

```json
{
	"minimum-stability": "dev",
	"require":
	{
		"icanboogie/common": "1.0.*"
	}
}
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/Common), its repository can be
cloned with the following command line:

	$ git clone git://github.com/ICanBoogie/Common.git





## Documentation

The package is documented as part of the [ICanBoogie](http://icanboogie.org/) framework
[documentation](http://icanboogie.org/docs/). You can generate the documentation for the package
and its dependencies with the `make doc` command. The documentation is generated in the `docs`
directory. [ApiGen](http://apigen.org/) is required. You can later clean the directory with
the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all dependencies required to run the suite. You can later
clean the directory with the `make clean` command.





## Available exceptions

### Offset exceptions

The following exceptions related to array offset are available:

* `OffsetError`: Exception thrown when there is something wrong with an array offset.
* `OffsetNotReadable`: Exception thrown when an array offset is not readable.
* `OffsetNotWritable`: Exception thrown when an array offset is not writable.





### Property exceptions

The following exceptions related to object properties are available:

* `PropertyError`: Exception thrown when there is something wrong with an object property.
* `PropertyNotDefined`: Exception thrown when a property is not defined.
* `PropertyNotReadable`: Exception thrown when a property is not readable.
* `PropertyNotWritable`: Exception thrown when a property is not writable.

```php
<?php

use ICanBoogie\PropertyNotDefined;

class A
{
	protected $id;

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





## License

ICanBoogie/Common is licensed under the New BSD License - See the LICENSE file for details.