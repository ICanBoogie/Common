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

/**
 * @property-read int $day Day of the month.
 * @property-read int $hour Hour of the day.
 * @property-read int $minute Minute of the hour.
 * @property-read int $month Month of the year.
 * @property-read int $quarter Quarter of the year.
 * @property-read int $second Second of the minute.
 * @property-read int $week Week of the year.
 * @property-read int $weekday Day of the week.
 * @property-read int $year Year.
 * @property-read int $year_day Day of the year.
 */
class DateTime extends \DateTime
{
	private $day;
	private $hour;
	private $minute;
	private $month;
	private $quarter;
	private $second;
	private $week;
	private $weekday;
	private $year;
	private $year_day;

	protected function revoke_properties()
	{
		$this->day = null;
		$this->hour = null;
		$this->minutes = null;
		$this->month = null;
		$this->quarter = null;
		$this->second = null;
		$this->week = null;
		$this->weekday = null;
		$this->year = null;
		$this->year_day = null;
	}

	public function __get($property)
	{
		if (property_exists($this, $property) && $this->$property !== null)
		{
			return $this->$property;
		}

		switch ($property)
		{
			case 'day':
				return $this->$property = (int) $this->format('d');
			case 'hour':
				return $this->$property = (int) $this->format('H');
			case 'minute':
				return $this->$property = (int) $this->format('i');
			case 'month':
				return $this->$property = (int) $this->format('m');
			case 'quarter':
				return $this->$property = floor(($this->__get('month') - 1) / 3) + 1;
			case 'second':
				return $this->$property = (int) $this->format('s');
			case 'week':
				return $this->$property = (int) $this->format('W');
			case 'weekday':
				return $this->$property = (int) $this->format('N');
			case 'year':
				return $this->$property = (int) $this->format('Y');
			case 'year_day':
				return $this->$property = (int) $this->format('z');
		}

		throw new PropertyNotDefined(array($property, $this));
	}

	public function modify($modify)
	{
		$this->revoke_properties();

		return parent::modify($modify);
	}

	public function setDate($year, $month, $day)
	{
		$this->revoke_properties();

		return parent::setDate($year, $month, $day);
	}

	public function setISODate($year, $week, $day=null)
	{
		$this->revoke_properties();

		return parent::setISODate($year, $week, $day);
	}

	public function setTime($hour, $minute, $second = null)
	{
		$this->revoke_properties();

		return parent::setTime($hour, $minute, $second);
	}

	public function setTimestamp($unixtimestamp)
	{
		$this->revoke_properties();

		return parent::setTimestamp($unixtimestamp);
	}

	public function setTimezone(/*\DateTimeZone*/ $timezone)
	{
		$this->revoke_properties();

		return parent::setTimezone($timezone);
	}

	public function add(/*\DateInterval*/ $interval)
	{
		$this->revoke_properties();

		return parent::add($interval);
	}

	public function sub(/*\DateInterval*/ $interval)
	{
		$this->revoke_properties();

		return parent::sub($interval);
	}
}