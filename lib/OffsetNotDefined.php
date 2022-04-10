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

use LogicException;
use Throwable;

/**
 * Exception thrown when an array offset is not defined.
 *
 * For example, this could be triggered by an offset out of bounds while setting an array value.
 */
class OffsetNotDefined extends LogicException implements OffsetError
{
    /**
     * @phpstan-param string|array{0: string|int, 1: array|object} $message
     */
    public function __construct(string|array $message, Throwable $previous = null)
    {
        if (is_array($message)) {
            [ $offset, $container ] = $message + [ 1 => null ];

            if (is_object($container)) {
                $message = format('Undefined offset %offset for object of class %class.', [
                    '%offset' => $offset,
                    '%class' => get_class($container)
                ]);
            } elseif (is_array($container)) {
                $message = format('Undefined offset %offset for the array: !array', [
                    '%offset' => $offset,
                    '!array' => $container
                ]);
            } else {
                $message = format('Undefined offset %offset.', [
                    '%offset' => $offset
                ]);
            }
        }

        parent::__construct($message, 0, $previous);
    }
}
