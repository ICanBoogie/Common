<?php

namespace ICanBoogie;

use LogicException;
use Throwable;

/**
 * Exception thrown when a property is not defined.
 *
 * For example, this could be triggered by getting the value of an undefined property.
 */
class PropertyNotDefined extends LogicException implements PropertyError
{
    public function __construct(
        public readonly string $property,
        public readonly object $container,
        ?string $message = null,
        ?Throwable $previous = null
    ) {
        $message ??= sprintf(
            "Undefined property '%s' for object of class '%s'",
            $property,
            $container::class
        );

        parent::__construct($message, previous: $previous);
    }
}
