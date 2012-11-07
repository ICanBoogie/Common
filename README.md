# Common

This package provides the basic classes and helpers shared by all [ICanBoogie](http://icanboogie.org/)
packages. It includes offset exceptions, property exceptions, and helpers to transform strings
and arrays.




## Requirement

PHP 5.3+ is required.




## Installation

The easiest way to install the package is to use [composer](http://getcomposer.org/).
Just create a `composer.json` file and run the `php composer.phar install` command:

```json
{
	"minium-stability": "dev",
	"require":
	{
		"icanboogie/common": "1.0.*"
	}
}
```




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