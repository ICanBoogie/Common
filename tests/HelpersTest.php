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

class HelpersTests extends \PHPUnit_Framework_TestCase
{
	public function testHyphenate()
	{
		$s = hyphenate('RenderOneEntity');
		$this->assertEquals('render-one-entity', $s);
	}

	public function testHyphenateConsecutiveCaps()
	{
		$s = hyphenate('RenderInnerHTML');
		$this->assertEquals('render-inner-html', $s);
	}
}