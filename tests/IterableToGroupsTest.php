<?php

namespace Test\ICanBoogie;

use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Acme\SampleObject;

use function ICanBoogie\iterable_to_groups;

final class IterableToGroupsTest extends TestCase
{
    public function test_iterable_to_groups_with_array(): void
    {
        $actual = iterable_to_groups(
            self::iterable_of_array(),
            fn(array $x): string => $x['offset']
        );

        $this->assertEquals([
            'a' => [
                [ 'offset' => "a", 'value' => 'V1' ],
                [ 'offset' => "a", 'value' => 'V2' ],
            ],
            'b' => [
                [ 'offset' => "b", 'value' => 'V3' ],
                [ 'offset' => "b", 'value' => 'V4' ]
            ],
            'c' => [
                [ 'offset' => "c", 'value' => 'V5' ],
            ],
        ], $actual);
    }

    public function test_iterable_to_groups_with_array_and_element_selector(): void
    {
        $actual = iterable_to_groups(
            self::iterable_of_array(),
            fn(array $x): string => $x['offset'],
            fn(array $x): string => $x['value']
        );

        $this->assertEquals([
            'a' => [ 'V1', 'V2' ],
            'b' => [ 'V3', 'V4' ],
            'c' => [ 'V5' ],
        ], $actual);
    }

    /**
     * @return iterable<array{ offset: string, value: string }>
     */
    private static function iterable_of_array(): iterable
    {
        yield [ 'offset' => "a", 'value' => 'V1' ];
        yield [ 'offset' => "a", 'value' => 'V2' ];
        yield [ 'offset' => "b", 'value' => 'V3' ];
        yield [ 'offset' => "b", 'value' => 'V4' ];
        yield [ 'offset' => "c", 'value' => 'V5' ];
    }

    public function test_iterable_to_groups_with_object(): void
    {
        $actual = iterable_to_groups(
            self::iterable_of_object(),
            fn(SampleObject $x): string => $x->key
        );

        $this->assertEquals([
            'a' => [
                new SampleObject('a', 'V1'),
                new SampleObject('a', 'V2'),
            ],
            'b' => [
                new SampleObject('b', 'V3'),
                new SampleObject('b', 'V4'),
            ],
            'c' => [
                new SampleObject('c', 'V5'),
            ]
        ], $actual);
    }

    public function test_iterable_to_groups_with_object_and_element_selector(): void
    {
        $actual = iterable_to_groups(
            self::iterable_of_object(),
            fn(SampleObject $x): string => $x->key,
            fn(SampleObject $x): string => $x->value,
        );

        $this->assertEquals([
            'a' => [ 'V1', 'V2' ],
            'b' => [ 'V3', 'V4' ],
            'c' => [ 'V5' ],
        ], $actual);
    }

    /**
     * @return iterable<SampleObject>
     */
    private static function iterable_of_object(): iterable
    {
        yield new SampleObject("a", 'V1' );
        yield new SampleObject("a", 'V2' );
        yield new SampleObject("b", 'V3' );
        yield new SampleObject("b", 'V4' );
        yield new SampleObject("c", 'V5' );
    }
}
