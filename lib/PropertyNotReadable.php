<?php

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
    public function __construct(
        public readonly string $property,
        public readonly object $container,
        ?string $message = null,
        ?Throwable $previous = null
    ) {
        $message ??= sprintf(
            "The property '%s' for object of class '%s is not readable.",
            $property,
            $container::class
        );

        parent::__construct($message, previous:  $previous);
    }
}
