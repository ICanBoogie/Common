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
 * Exception thrown when a property is not writable.
 *
 * For example, this could be triggered when a private property is written from a public scope.
 */
class PropertyNotWritable extends LogicException implements PropertyError
{
    /**
     * @param string|array $message
     *
     * @phpstan-param string|array{0: string, 1: object} $message
     */
    public function __construct($message, Throwable $previous = null)
    {
        if (is_array($message)) {
            [ $property, $container ] = $message + [ 1 => null ];

            if (is_object($container)) {
                $message = format('The property %property for object of class %class is not writable.', [
                    '%property' => $property,
                    '%class' => get_class($container)
                ]);
            } else {
                $message = format('The property %property is not writable.', [
                    '%property' => $property
                ]);
            }
        }

        parent::__construct($message, 0, $previous);
    }
}
