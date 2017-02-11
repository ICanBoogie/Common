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
 * Exception thrown when an array offset is not writable.
 */
class OffsetNotWritable extends OffsetError
{
	public function __construct($message, $code=500, \Exception $previous=null)
	{
		if (is_array($message))
		{
			list($offset, $container) = $message + array(1 => null);

			if (is_object($container))
			{
				$message = format
				(
					'The offset %offset for object of class %class is not writable.', array
					(
						'offset' => $offset,
						'class' => get_class($container)
					)
				);
			}
			else if (is_array($container))
			{
				$message = format
				(
					'The offset %offset is not writable for the array: !array', array
					(
						'offset' => $offset,
						'array' => $container
					)
				);
			}
			else
			{
				$message = format
				(
					'The offset %offset is not writable.', array
					(
						'offset' => $offset
					)
				);
			}
		}

		parent::__construct($message, $code, $previous);
	}
}
