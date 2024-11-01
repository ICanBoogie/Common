<?php

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
     * @phpstan-ignore-next-line
     */
    public function __construct(
        public readonly string|int $offset,
        public readonly array|object|null $container = null,
        ?string $message = null,
        ?Throwable $previous = null
    ) {
        if (!$message) {
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

        parent::__construct($message, previous: $previous);
    }
}
