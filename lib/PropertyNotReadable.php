<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

/**
 * Exception thrown when a property is not readable.
 *
 * For example, this could be triggered when a private property is read from a public scope.
 */
class PropertyNotReadable extends PropertyError
{
	public function __construct($message, $code=500, \Exception $previous=null)
	{
		if (is_array($message))
		{
			list($property, $container) = $message + array(1 => null);

			if (is_object($container))
			{
				$message = format
				(
					'The property %property for object of class %class is not readable.', array
					(
						'%property' => $property,
						'%class' => get_class($container)
					)
				);
			}
			else
			{
				$message = format
				(
					'The property %property is not readable.', array
					(
						'%property' => $property
					)
				);
			}
		}

		parent::__construct($message, $code, $previous);
	}
}
