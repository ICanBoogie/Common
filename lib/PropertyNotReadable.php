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
 * Exception thrown when a property is not readable.
 *
 * For example, this could be triggered when a private property is read from a public scope.
 */
class PropertyNotReadable extends LogicException implements PropertyError
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

            $message = format('The property %property for object of class %class is not readable.', [
                '%property' => $property,
                '%class' => get_class($container)
            ]);
        }

        parent::__construct($message, 0, $previous);
    }
}
