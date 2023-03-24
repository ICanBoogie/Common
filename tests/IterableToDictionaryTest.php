<?php

namespace Test\ICanBoogie;

use PHPUnit\Framework\TestCase;

use Test\ICanBoogie\Acme\SampleObject;

use function ICanBoogie\iterable_to_dictionary;

final class IterableToDictionaryTest extends TestCase
{
    public function test_iterable_to_dictionary_with_array(): void
    {
        $actual = iterable_to_dictionary(
            self::iterable_of_array(),
            fn(array $x): string => $x['offset']
        );

        $this->assertEquals([
            'a' => [ 'offset' => "a", 'value' => 'V1' ],
            'b' => [ 'offset' => "b", 'value' => 'V2' ],
            'c' => [ 'offset' => "c", 'value' => 'V3' ],
        ], $actual);
    }

    public function test_iterable_to_dictionary_with_array_and_element_selector(): void
    {
        $actual = iterable_to_dictionary(
            self::iterable_of_array(),
            fn(array $x): string => $x['offset'],
            fn(array $x): string => $x['value']
        );

        $this->assertEquals([
            'a' => 'V1',
            'b' => 'V2',
            'c' => 'V3',
        ], $actual);
    }

    /**
     * @return iterable<array{ offset: string, value: string }>
     */
    private static function iterable_of_array(): iterable
    {
        yield [ 'offset' => "a", 'value' => 'V1' ];
        yield [ 'offset' => "b", 'value' => 'V2' ];
        yield [ 'offset' => "c", 'value' => 'V3' ];
    }

    public function test_iterable_to_dictionary_with_object(): void
    {
        $actual = iterable_to_dictionary(
            self::iterable_of_object(),
            fn(SampleObject $x): string => $x->key
        );

        $this->assertEquals([
            'a' => new SampleObject('a', 'V1'),
            'b' => new SampleObject('b', 'V2'),
            'c' => new SampleObject('c', 'V3'),
        ], $actual);
    }

    public function test_iterable_to_dictionary_with_object_and_element_selector(): void
    {
        $actual = iterable_to_dictionary(
            self::iterable_of_object(),
            fn(SampleObject $x): string => $x->key,
            fn(SampleObject $x): string => $x->value,
        );

        $this->assertEquals([
            'a' => 'V1',
            'b' => 'V2',
            'c' => 'V3',
        ], $actual);
    }

    /**
     * @return iterable<SampleObject>
     */
    private static function iterable_of_object(): iterable
    {
        yield new SampleObject("a", 'V1' );
        yield new SampleObject("b", 'V2' );
        yield new SampleObject("c", 'V3' );
    }
}
