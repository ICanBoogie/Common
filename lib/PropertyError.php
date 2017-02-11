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
 * Exception thrown when there is something wrong with an object property.
 *
 * This is the base class for property exceptions, one should rather use the
 * {@link PropertyNotDefined}, {@link PropertyNotReadable} or {@link PropertyNotWritable}
 * exceptions.
 */
class PropertyError extends \RuntimeException
{

}
