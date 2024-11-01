<?php

namespace ICanBoogie;

use LogicException;
use Throwable;

/**
 * Exception thrown when a property has a reserved name.
 *
 * @property-read string $property Name of the reserved property.
 */
class PropertyIsReserved extends LogicException implements PropertyError
{
    public function __construct(
        public readonly string $property,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            "Property '$property' is reserved",
            previous: $previous
        );
    }
}
