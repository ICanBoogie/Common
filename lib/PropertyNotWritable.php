<?php

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
    public function __construct(
        public readonly string $property,
        public readonly object $container,
        ?string $message = null,
        ?Throwable $previous = null
    ) {
        $message ??= sprintf(
            "The property '%s' for object of class '%s' is not writable",
            $property,
            $container::class,
        );

        parent::__construct($message, previous: $previous);
    }
}
