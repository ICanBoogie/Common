<?php

namespace Test\ICanBoogie\Acme;

final class SampleObject
{
    public function __construct(
        public readonly string $key,
        public readonly string $value,
    ) {
    }
}
