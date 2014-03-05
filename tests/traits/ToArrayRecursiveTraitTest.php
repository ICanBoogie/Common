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

use ICanBoogie\ToArrayRecursiveTraitTest\A;

class ToArrayRecursiveTraitTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_instances
	 */
	public function test_to_array_recursive($instance, $expected)
	{
		$this->assertEquals($expected, $instance->to_array_recursive());
	}

	public function provide_instances()
	{
		return [

			[
				new A([ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ] ]),

				[ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ]]

			],

			[
				new A([ 'a' => 'a', 'b' => 'b', 'c' => (object) [ 'A' => 'A', 'B' => 'B' ] ]),

				[ 'a' => 'a', 'b' => 'b', 'c' => (object) [ 'A' => 'A', 'B' => 'B' ]]

			],

			[
				new A([ 'a' => 'a', 'b' => 'b', 'c' => new A([ 'A' => 'A', 'B' => 'B' ]) ]),

				[ 'a' => 'a', 'b' => 'b', 'c' => [ 'A' => 'A', 'B' => 'B' ]]

			]

		];
	}
}

namespace ICanBoogie\ToArrayRecursiveTraitTest;

use ICanBoogie\ToArrayRecursive;
use ICanBoogie\ToArrayRecursiveTrait;

class A implements ToArrayRecursive
{
	use ToArrayRecursiveTrait;

	public function __construct(array $properties)
	{
		foreach ($properties as $property => $value)
		{
			$this->$property = $value;
		}
	}

	public function to_array()
	{
		return (array) $this;
	}
}