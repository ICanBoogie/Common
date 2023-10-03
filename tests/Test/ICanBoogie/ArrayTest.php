<?php

namespace Test\ICanBoogie;

use PHPUnit\Framework\TestCase;

use function ICanBoogie\iterable_every;
use function ICanBoogie\iterable_some;

final class ArrayTest extends TestCase
{
    public function test_iterable_every(): void
    {
        $is_below = fn($max) => fn($value) => $value < $max;
        $items = [ 1, 30, 39, 29, 10, 13 ];

        $this->assertTrue(iterable_every($items, $is_below(40)));
        $this->assertFalse(iterable_every($items, $is_below(30)));
    }

    public function test_iterable_some(): void
    {
        $is_above = fn($max) => fn($value) => $value > $max;
        $items = [ 1, 30, 39, 29, 10, 13 ];

        $this->assertFalse(iterable_some($items, $is_above(40)));
        $this->assertTrue(iterable_some($items, $is_above(30)));
    }
}
