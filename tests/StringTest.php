<?php

namespace Test\ICanBoogie;

use PHPUnit\Framework\TestCase;

use function ICanBoogie\trim_prefix;
use function ICanBoogie\trim_suffix;

final class StringTest extends TestCase
{
    public function test_trim_prefix(): void
    {
        $this->assertEquals("madonna", trim_prefix("madonna", "foo"));
        $this->assertEquals("madonnafoo", trim_prefix("madonnafoo", "foo"));
        $this->assertEquals("madonna", trim_prefix("foomadonna", "foo"));
    }

    public function test_trim_suffix(): void
    {
        $this->assertEquals("madonna", trim_suffix("madonna", "foo"));
        $this->assertEquals("madonna", trim_suffix("madonnafoo", "foo"));
        $this->assertEquals("foomadonna", trim_suffix("foomadonna", "foo"));
    }
}
