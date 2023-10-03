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
 * Exception thrown when an array offset is not writable.
 */
class OffsetNotWritable extends LogicException implements OffsetError
{
    /**
     * @phpstan-ignore-next-line
     */
    public function __construct(
        public readonly string|int $offset,
        public readonly array|object|null $container = null,
        string $message = null,
        Throwable $previous = null
    ) {
        if (!$message) {
            if (is_object($container)) {
                $message = format('The offset %offset for object of class %class is not writable.', [
                    'offset' => $offset,
                    'class' => get_class($container)
                ]);
            } elseif (is_array($container)) {
                $message = format('The offset %offset is not writable for the array: !array', [
                    'offset' => $offset,
                    'array' => $container
                ]);
            } else {
                $message = format('The offset %offset is not writable.', [
                    'offset' => $offset
                ]);
            }
        }

        parent::__construct($message, previous: $previous);
    }
}
