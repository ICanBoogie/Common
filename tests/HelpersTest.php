<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

class HelpersTest extends \PHPUnit_Framework_TestCase
{
	public function arrayProvider()
	{
		return array
		(
			array
			(
				array
				(
					'one' => array
					(
						'one' => 1,
						'two' => array
						(
							'one' => 1,
							'two' => 2,
							'three' => array
							(
								'one' => 1,
								'two' => 2,
								'three' => 3
							)
						),

						'three' => array
						(
							'one' => array
							(
								'one' => 1,
								'two' => 2,
								'three' => 3
							),

							'two' => array
							(
								'one' => 1,
								'two' => 2,
								'three' => 3
							),

							'three' => 3
						)
					),

					'two' => array
					(
						'one' => 1,
						'two' => 2,
						'three' => 3
					)
				)
			)
		);
	}

	/**
	 * @dataProvider arrayProvider()
	 */
	public function testArrayFlatten($data)
	{
		$flat = array_flatten($data);

		$this->assertEquals
		(
			array
			(
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
			),

			$flat
		);
	}

	/**
	 * @dataProvider arrayProvider()
	 */
	public function testArrayFlattenDouble($data)
	{
		$flat = array_flatten($data, array('[', ']'));

		$this->assertEquals
		(
			array
			(
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
			),

			$flat
		);
	}

	/**
	 * @dataProvider provide_test_sort_by_weight
	 */
	public function test_sort_by_weight($array, $expected)
	{
		$this->assertSame($expected, sort_by_weight($array, function($v) { return $v; }));
	}

	public function provide_test_sort_by_weight()
	{
		return array
		(
			#1

			array
			(
				array
				(
					'bottom' => 'bottom',
					'min' => -10000,
					'max' => 10000,
					'top' => 'top'
				),

				array
				(
					'top' => 'top',
					'min' => -10000,
					'max' => 10000,
					'bottom' => 'bottom'
				)
			),

			#3: missing relative

			array
			(
				array
				(
					'two' => 2,
					'one' => 1,
					'four' => 'after:three'
				),

				array
				(
					'four' => 'after:three',
					'one' => 1,
					'two' => 2
				)
			),

			#2

			array
			(
				array
				(
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
				),

				array
				(
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
				)
			)
		);
	}

	/**
	 * @dataProvider provide_test_remove_accents
	 */
	public function test_remove_accents($expected, $str)
	{
		$this->assertEquals($expected, remove_accents($str));
	}

	public function provide_test_remove_accents()
	{
		return array
		(
			array('AAAAAAAE', 'ÁÀÂÄÃÅÆ'),
			array('aaaaaaae', 'áàâäãåæ'),
			array('C', 'Ç'),
			array('c', 'ç'),
			array('EEEE', 'ÉÈÊË'),
			array('eeee', 'éèêë'),
			array('IIII', 'ÍÏÎÌ'),
			array('iiii', 'íìîï'),
			array('N', 'Ñ'),
			array('n', 'ñ'),
			array('OOOOO', 'ÓÒÔÖÕ'),
			array('oooooo', 'óòôöõø'),
			array('S', 'Š'),
			array('s', 'š'),
			array('UUUU', 'ÚÙÛÜ'),
			array('uuuu', 'úùûü'),
			array('YY', 'ÝŸ'),
			array('yy', 'ýÿ')
		);
	}
}