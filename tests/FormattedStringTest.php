<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Common\Tests\FormattedString;

use ICanBoogie\FormattedString;

class CommonTest extends \PHPUnit_Framework_TestCase // TODO-20121123: this are format() mostly
{
	public function testNoArgs()
	{
		$s = new FormattedString('Testing... :a :b');
		$this->assertEquals('Testing... :a :b', (string) $s);
	}

	public function testArgsArray()
	{
		$s = new FormattedString('Testing... :a :b', array('a' => 'A', 'b' => 'B'));
		$this->assertEquals('Testing... A B', (string) $s);
	}

	public function testArgArrayAsIndex()
	{
		$s = new FormattedString('Testing... {0} {1}', array('a' => 'A', 'b' => 'B'));
		$this->assertEquals('Testing... A B', (string) $s);
	}

	public function testArgArrayIndex()
	{
		$s = new FormattedString('Testing... {0} {1}', array('A', 'B'));
		$this->assertEquals('Testing... A B', (string) $s);
	}

	public function testArgList()
	{
		$s = new FormattedString('Testing... {0} {1}', 'A', 'B');
		$this->assertEquals('Testing... A B', (string) $s);
	}

	public function testEscaping()
	{
		$s = new FormattedString('Testing... !a', array('a' => '<>'));
		$this->assertEquals('Testing... &lt;&gt;', (string) $s);
	}

	/**
	 * The string shall not be formatted because we explicitely requested escaping.
	 */
	public function testExplicitEscaping()
	{
		$s = new FormattedString('Testing... :a', array('!a' => '<>'));
		$this->assertEquals('Testing... :a', (string) $s);
	}

	public function testQuoting()
	{
		$s = new FormattedString('Testing... %a', array('a' => 'A'));
		$this->assertEquals('Testing... "A"', (string) $s);
	}

	/**
	 * The string shall not be formatted because we explicitely requested quoting.
	 */
	public function testExplicitQuoting()
	{
		$s = new FormattedString('Testing... :a', array('%a' => 'A'));
		$this->assertEquals('Testing... :a', (string) $s);
	}

	public function testQuotingEscaped()
	{
		$s = new FormattedString('Testing... %a', array('a' => 'A<>'));
		$this->assertEquals('Testing... "A&lt;&gt;"', (string) $s);
	}

	public function testAsIs()
	{
		$s = new FormattedString('Testing... :a', array('a' => 'A<>'));
		$this->assertEquals('Testing... A<>', (string) $s);
	}
}