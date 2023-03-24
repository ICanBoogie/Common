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

/**
 * A formatted string.
 *
 * The string is formatted by replacing placeholders with the values provided.
 */
class FormattedString
{
    /**
     * @param string $format
     *     String format.
     * @param array<int|string, mixed> $args
     *     Format arguments.
     *
     * @see format()
     */
    public function __construct(
        private readonly string $format,
        private readonly array $args = []
    ) {
    }

    /**
     * Returns the string formatted with the {@link format()} function.
     */
    public function __toString(): string
    {
        return format($this->format, $this->args);
    }
}
