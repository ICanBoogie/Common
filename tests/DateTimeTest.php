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

class DateTimeTests extends \PHPUnit_Framework_TestCase
{
	public function testYear()
	{
		$d = new DateTime('2012-12-16 15:00:00');
		$this->assertEquals(2012, $d->year);
		$d = new DateTime('0000-12-16 15:00:00');
		$this->assertEquals(0, $d->year);
		$d = new DateTime('9999-12-16 15:00:00');
		$this->assertEquals(9999, $d->year);
	}

	public function testQuarter()
	{
		$d = new DateTime('2012-01-16 15:00:00');
		$this->assertEquals(1, $d->quarter);
		$d = new DateTime('2012-02-16 15:00:00');
		$this->assertEquals(1, $d->quarter);
		$d = new DateTime('2012-03-16 15:00:00');
		$this->assertEquals(1, $d->quarter);
		$d = new DateTime('2012-04-16 15:00:00');
		$this->assertEquals(2, $d->quarter);
		$d = new DateTime('2012-05-16 15:00:00');
		$this->assertEquals(2, $d->quarter);
		$d = new DateTime('2012-06-16 15:00:00');
		$this->assertEquals(2, $d->quarter);
		$d = new DateTime('2012-07-16 15:00:00');
		$this->assertEquals(3, $d->quarter);
		$d = new DateTime('2012-08-16 15:00:00');
		$this->assertEquals(3, $d->quarter);
		$d = new DateTime('2012-09-16 15:00:00');
		$this->assertEquals(3, $d->quarter);
		$d = new DateTime('2012-10-16 15:00:00');
		$this->assertEquals(4, $d->quarter);
		$d = new DateTime('2012-11-16 15:00:00');
		$this->assertEquals(4, $d->quarter);
		$d = new DateTime('2012-12-16 15:00:00');
		$this->assertEquals(4, $d->quarter);
	}

	public function testMonth()
	{
		$d = new DateTime('2012-01-16 15:00:00');
		$this->assertEquals(1, $d->month);
		$d = new DateTime('2012-06-16 15:00:00');
		$this->assertEquals(6, $d->month);
		$d = new DateTime('2012-12-16 15:00:00');
		$this->assertEquals(12, $d->month);
	}

	public function testWeek()
	{
		$d = new DateTime('2012-01-01 15:00:00');
		$this->assertEquals(52, $d->week);
		$d = new DateTime('2012-01-16 15:00:00');
		$this->assertEquals(3, $d->week);
	}

	public function testYearDay()
	{
		$d = new DateTime('2012-01-01 15:00:00');
		$this->assertEquals(1, $d->year_day);
		$d = new DateTime('2012-12-31 15:00:00');
		$this->assertEquals(366, $d->year_day);
	}

	/**
	 * Sunday must be 7, Monday must be 1.
	 */
	public function testWeekDay()
	{
		$d = new DateTime('2012-12-17 15:00:00');
		$this->assertEquals(1, $d->weekday);
		$d = new DateTime('2012-12-18 15:00:00');
		$this->assertEquals(2, $d->weekday);
		$d = new DateTime('2012-12-19 15:00:00');
		$this->assertEquals(3, $d->weekday);
		$d = new DateTime('2012-12-20 15:00:00');
		$this->assertEquals(4, $d->weekday);
		$d = new DateTime('2012-12-21 15:00:00');
		$this->assertEquals(5, $d->weekday);
		$d = new DateTime('2012-12-22 15:00:00');
		$this->assertEquals(6, $d->weekday);
		$d = new DateTime('2012-12-23 15:00:00');
		$this->assertEquals(7, $d->weekday);
	}

	public function testDay()
	{
		$d = new DateTime('2012-12-16 15:00:00');
		$this->assertEquals(16, $d->day);
		$d = new DateTime('2012-12-17 15:00:00');
		$this->assertEquals(17, $d->day);
		$d = new DateTime('2013-01-01 03:00:00');
		$this->assertEquals(1, $d->day);
	}

	public function testHour()
	{
		$d = new DateTime('2013-01-01 01:23:45');
		$this->assertEquals(1, $d->hour);
	}

	public function testMinute()
	{
		$d = new DateTime('2013-01-01 01:23:45');
		$this->assertEquals(23, $d->minute);
	}

	public function testSecond()
	{
		$d = new DateTime('2013-01-01 01:23:45');
		$this->assertEquals(45, $d->second);
	}
}