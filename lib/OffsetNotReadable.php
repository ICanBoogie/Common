<?php

namespace ICanBoogie;

use LogicException;
use Throwable;

/**
 * Exception thrown when an array offset is not readable.
 */
class OffsetNotReadable extends LogicException implements OffsetError
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
                $message = format('The offset %offset for object of class %class is not readable.', [
                    'offset' => $offset,
                    'class' => get_class($container)
                ]);
            } elseif (is_array($container)) {
                $message = format('The offset %offset is not readable for the array: !array', [
                    'offset' => $offset,
                    'array' => $container
                ]);
            } else {
                $message = format('The offset %offset is not readable.', [
                    'offset' => $offset
                ]);
            }
        }

        parent::__construct($message, previous: $previous);
    }
}
