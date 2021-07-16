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

use function ICanBoogie\array_flatten;
use function ICanBoogie\format;
use function ICanBoogie\remove_accents;
use function ICanBoogie\sort_by_weight;

final class HelpersTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function arrayProvider(): array
    {
        return [
            [
                [
                    'one' => [
                        'one' => 1,
                        'two' => [
                            'one' => 1,
                            'two' => 2,
                            'three' => [
                                'one' => 1,
                                'two' => 2,
                                'three' => 3
                            ]
                        ],

                        'three' => [
                            'one' => [
                                'one' => 1,
                                'two' => 2,
                                'three' => 3
                            ],

                            'two' => [
                                'one' => 1,
                                'two' => 2,
                                'three' => 3
                            ],

                            'three' => 3
                        ]
                    ],

                    'two' => [
                        'one' => 1,
                        'two' => 2,
                        'three' => 3
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider arrayProvider()
     *
     * @phpstan-ignore-next-line
     */
    public function testArrayFlatten(array $data): void
    {
        $flat = array_flatten($data);

        $this->assertEquals([
            'one.one' => 1,
            'one.two.one' => 1,
            'one.two.two' => 2,
            'one.two.three.one' => 1,
            'one.two.three.two' => 2,
            'one.two.three.three' => 3,
            'one.three.one.one' => 1,
            'one.three.one.two' => 2,
            'one.three.one.three' => 3,
            'one.three.two.one' => 1,
            'one.three.two.two' => 2,
            'one.three.two.three' => 3,
            'one.three.three' => 3,
            'two.one' => 1,
            'two.two' => 2,
            'two.three' => 3
        ], $flat);
    }

    /**
     * @dataProvider arrayProvider()
     *
     * @phpstan-ignore-next-line
     */
    public function testArrayFlattenDouble(array $data)
    {
        $flat = array_flatten($data, [ '[', ']' ]);

        $this->assertEquals([
            'one[one]' => 1,
            'one[two][one]' => 1,
            'one[two][two]' => 2,
            'one[two][three][one]' => 1,
            'one[two][three][two]' => 2,
            'one[two][three][three]' => 3,
            'one[three][one][one]' => 1,
            'one[three][one][two]' => 2,
            'one[three][one][three]' => 3,
            'one[three][two][one]' => 1,
            'one[three][two][two]' => 2,
            'one[three][two][three]' => 3,
            'one[three][three]' => 3,
            'two[one]' => 1,
            'two[two]' => 2,
            'two[three]' => 3
        ], $flat);
    }

    /**
     * @dataProvider provide_test_sort_by_weight
     *
     * @phpstan-ignore-next-line
     */
    public function test_sort_by_weight(array $array, array $expected): void
    {
        $this->assertSame($expected, sort_by_weight($array, function ($v) {
            return $v;
        }));
    }

    // @phpstan-ignore-next-line
    public function provide_test_sort_by_weight(): array
    {
        return [
            #1

            [
                [
                    'bottom' => 'bottom',
                    'min' => -10000,
                    'max' => 10000,
                    'top' => 'top'
                ],

                [
                    'top' => 'top',
                    'min' => -10000,
                    'max' => 10000,
                    'bottom' => 'bottom'
                ]
            ],

            "missing relative" => [
                [
                    'two' => 2,
                    'one' => 1,
                    'four' => 'after:three'
                ],

                [
                    'four' => 'after:three',
                    'one' => 1,
                    'two' => 2
                ]
            ],

            [
                [
                    'two' => 0,
                    'three' => 0,
                    'bottom' => 'bottom',
                    'megabottom' => 'bottom',
                    'hyperbottom' => 'bottom',
                    'one' => 'before:two',
                    'four' => 'after:three',
                    'top' => 'top',
                    'megatop' => 'top',
                    'hypertop' => 'top'
                ],

                [
                    'hypertop' => 'top',
                    'megatop' => 'top',
                    'top' => 'top',
                    'one' => 'before:two',
                    'two' => 0,
                    'three' => 0,
                    'four' => 'after:three',
                    'bottom' => 'bottom',
                    'megabottom' => 'bottom',
                    'hyperbottom' => 'bottom'
                ]
            ]
        ];
    }

    /**
     * @dataProvider provide_test_remove_accents
     */
    public function test_remove_accents(string $expected, string $str): void
    {
        $this->assertEquals($expected, remove_accents($str));
    }

    // @phpstan-ignore-next-line
    public function provide_test_remove_accents(): array
    {
        return [
            [ 'AAAAAAAE', 'ÁÀÂÄÃÅÆ' ],
            [ 'aaaaaaae', 'áàâäãåæ' ],
            [ 'C', 'Ç' ],
            [ 'c', 'ç' ],
            [ 'EEEE', 'ÉÈÊË' ],
            [ 'eeee', 'éèêë' ],
            [ 'IIII', 'ÍÏÎÌ' ],
            [ 'iiii', 'íìîï' ],
            [ 'N', 'Ñ' ],
            [ 'n', 'ñ' ],
            [ 'OOOOO', 'ÓÒÔÖÕ' ],
            [ 'oooooo', 'óòôöõø' ],
            [ 'S', 'Š' ],
            [ 's', 'š' ],
            [ 'UUUU', 'ÚÙÛÜ' ],
            [ 'uuuu', 'úùûü' ],
            [ 'YY', 'ÝŸ' ],
            [ 'yy', 'ýÿ' ]
        ];
    }

    /**
     * @dataProvider provide_test_format
     *
     * @phpstan-ignore-next-line
     */
    public function test_format(string $format, array $args, string $expected): void
    {
        $this->assertEquals($expected, format($format, $args));
    }

    // @phpstan-ignore-next-line
    public function provide_test_format(): array
    {
        return [

            [ "abc \\0", [ '<def' ], "abc <def" ],
            [ "abc {0}", [ '<def' ], "abc <def" ],
            [ "abc {a1}", [ 'a1' => '<def' ], "abc &lt;def" ],
            [ "abc :a1", [ 'a1' => '<def' ], "abc <def" ],
            [ "abc !a1", [ 'a1' => '<def' ], "abc &lt;def" ],
            [ "abc %a1", [ 'a1' => '<def' ], "abc `&lt;def`" ]

        ];
    }
}
