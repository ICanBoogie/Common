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
 * Exception thrown when there is something wrong with an array offset.
 *
 * This is the base class for offset exceptions, one should rather use the
 * {@link OffsetNotReadable} or {@link OffsetNotWritable} exceptions.
 */
class OffsetError extends \RuntimeException
{

}
