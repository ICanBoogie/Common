<?php

namespace Test\ICanBoogie;

use PHPUnit\Framework\TestCase;

final class ToArrayRecursiveTraitTest extends TestCase
{
    /**
     * @dataProvider provide_instances
     *
     * @phpstan-ignore-next-line
     */
    public function test_to_array_recursive(SampleToArrayRecursive $instance, array $expected): void
    {
        $this->assertEquals($expected, $instance->to_array_recursive());
    }

    // @phpstan-ignore-next-line
    public static function provide_instances(): array
    {
        return [

            [
                new SampleToArrayRecursive([ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ] ]),
                [ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ] ]
            ],

            [
                new SampleToArrayRecursive([ 'a' => 'a', 'b' => 'b', 'c' => (object) [ 'A' => 'A', 'B' => 'B' ] ]),
                [ 'a' => 'a', 'b' => 'b', 'c' => (object) [ 'A' => 'A', 'B' => 'B' ] ]
            ],

            [
                new SampleToArrayRecursive([
                    'a' => 'a',
                    'b' => 'b',
                    'c' => new SampleToArrayRecursive([ 'A' => 'A', 'B' => 'B' ])
                ]),
                [ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ] ]
            ]

        ];
    }
}
