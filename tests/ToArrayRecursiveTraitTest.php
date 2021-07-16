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

use PHPUnit\Framework\TestCase;

final class ToArrayRecursiveTraitTest extends TestCase
{
    /**
     * @dataProvider provide_instances
     */
    public function test_to_array_recursive(SampleToArrayRecursive $instance, array $expected): void
    {
        $this->assertEquals($expected, $instance->to_array_recursive());
    }

    public function provide_instances(): array
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
