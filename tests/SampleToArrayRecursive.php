<?php

namespace Test\ICanBoogie;

use ICanBoogie\ToArrayRecursive;
use ICanBoogie\ToArrayRecursiveTrait;

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
