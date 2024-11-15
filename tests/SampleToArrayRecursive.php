<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\ICanBoogie;

use AllowDynamicProperties;
use ICanBoogie\ToArrayRecursive;
use ICanBoogie\ToArrayRecursiveTrait;

#[AllowDynamicProperties]
class SampleToArrayRecursive implements ToArrayRecursive
{
    use ToArrayRecursiveTrait;

    // @phpstan-ignore-next-line
    public function __construct(array $properties)
    {
        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }
    }

    public function to_array(): array
    {
        return (array) $this;
    }
}
