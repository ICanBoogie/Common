<?php

namespace Test\ICanBoogie;

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
