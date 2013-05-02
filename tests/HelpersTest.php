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
}