<?php

namespace libraries\korn\utils;

use DateTime;
use Exception;

class KornDateTime {
	private DateTime $dateTime;

	public function __construct(string|DateTime $time = null) {
		if ($time instanceof DateTime) {
			$this->dateTime = $time;
		}
		else if ($time) {
			try {
				$this->dateTime = new DateTime($time);
			}
			catch (Exception $e) {
				KornDebug::printError('ERROR: Failed to parse time string', $e->getMessage());
			}
		}
		else {
			$this->dateTime = new DateTime();
		}
	}

	public static function createFromDateThai(int $date, int $month, int $year): KornDateTime|null {
		return self::createFromDate($date, $month, $year - 543);
	}
	public static function createFromDate(int $date, int $month, int $year): KornDateTime|null {
		$dateTime = DateTime::createFromFormat('Y-n-d', $year.'-'.$month.'-'.$date);
		if ($dateTime)
			return new KornDateTime($dateTime);

		return null;
	}
	public static function createFromDateTimeThai(int $date, int $month, int $year, int $hour, int $minute, int $second): KornDateTime|null {
		return self::createFromDateTime($date, $month, $year - 543, $hour, $minute, $second);
	}
	public static function createFromDateTime(int $date, int $month, int $year, int $hour, int $minute, int $second): KornDateTime|null {
		$dateTime = DateTime::createFromFormat('Y-n-d G:i:s', $year.'-'.$month.'-'.$date.' '.$hour.':'.str_pad($minute, 2, '0', STR_PAD_LEFT).':'.str_pad($second, 2, '0', STR_PAD_LEFT));
		if ($dateTime)
			return new KornDateTime($dateTime);

		return null;
	}

	public function getSecond(): int {
		return $this->dateTime->format('s');
	}
	public function getMinute(): int {
		return $this->dateTime->format('i');
	}
	public function getHour(): int {
		return $this->dateTime->format('G');
	}

	public function getDay(): string {
		return $this->dateTime->format('l');
	}
	public function getDayThai(): string {
		return match ($this->getDayShort()) {
			'Mon'   => 'จันทร์',
			'Tue'   => 'อังคาร',
			'Wed'   => 'พุธ',
			'Thu'   => 'พฤหัสบดี',
			'Fri'   => 'ศุกร์',
			'Sat'   => 'เสาร์',
			'Sun'   => 'อาทิตย์',
			default => '',
		};
	}
	public function getDayShort(): string {
		return $this->dateTime->format('D');
	}
	public function getDayShortThai(): string {
		return match ($this->getDayShort()) {
			'Mon'   => 'จ.',
			'Tue'   => 'อ.',
			'Wed'   => 'พ.',
			'Thu'   => 'พฤ.',
			'Fri'   => 'ศ.',
			'Sat'   => 'ส.',
			'Sun'   => 'อา.',
			default => '',
		};
	}

	public function getDate(): int {
		return $this->dateTime->format('j');
	}

	public function getMonth(): int {
		return $this->dateTime->format('n');
	}

	public function getMonthString(): string {
		return $this->dateTime->format('F');
	}
	public function getMonthStringThai(): string {
		return match ($this->getMonth()) {
			1  => 'มกราคม',
			2  => 'กุมภาพันธ์',
			3  => 'มีนาคม',
			4  => 'เมษายน',
			5  => 'พฤษภาคม',
			6  => 'มิถุนายน',
			7  => 'กรกฎาคม',
			8  => 'สิงหาคม',
			9  => 'กันยายน',
			10 => 'ตุลาคม',
			11 => 'พฤศจิกายน',
			12 => 'ธันวาคม',
		};
	}
	public function getMonthStringShort(): string {
		return $this->dateTime->format('M');
	}
	public function getMonthStringShortThai(): string {
		return match ($this->getMonth()) {
			1  => 'ม.ค.',
			2  => 'ก.พ.',
			3  => 'มี.ค.',
			4  => 'เม.ย.',
			5  => 'พ.ค.',
			6  => 'มิ.ย.',
			7  => 'ก.ค.',
			8  => 'ส.ค.',
			9  => 'ก.ย.',
			10 => 'ต.ค.',
			11 => 'พ.ย.',
			12 => 'ธ.ค.',
		};
	}

	public function getYear(): int {
		return $this->dateTime->format('Y');
	}
	public function getYearShort(): int {
		return $this->getYear() % 100;
	}
	public function getYearThai(): int {
		return $this->getYear() + 543;
	}
	public function getYearShortThai(): int {
		return $this->getYearThai() % 100;
	}

	public function toString(): string {
		return $this->getDate().' '.
		       $this->getMonthString().' '.
		       $this->getYear();
	}
	public function toStringThai(): string {
		return $this->getDate().' '.
		       $this->getMonthStringThai().' '.
		       $this->getYearThai();
	}
	public function toStringThaiFormal(): string {
		return 'วัน'.$this->getDayThai().'ที่ '.
		       $this->getDate().' '.
		       $this->getMonthStringThai().' '.
		       'พ.ศ.'.$this->getYearThai();
	}
	public function toStringShort(): string {
		return $this->getDate().' '.
		       $this->getMonthStringShort().' '.
		       $this->getYear();
	}
	public function toStringShortThai(): string {
		return $this->getDate().' '.
		       $this->getMonthStringShortThai().' '.
		       $this->getYearThai();
	}
	public function toStringShortThaiFormal(): string {
		return 'วัน'.$this->getDayThai().'ที่ '.
		       $this->getDate().' '.
		       $this->getMonthStringShortThai().' '.
		       $this->getYearThai();
	}

	public function toStringTime(): string {
		return $this->dateTime->format('H:i:s');
	}

	public function toMySQLDate(): string {
		return $this->dateTime->format('Y-m-d');
	}
	public function toMySQLDateTime(): string {
		return $this->dateTime->format('Y-m-d H:i:s');
	}

	public function getMonths(): array {
		return [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
		];
	}
	public function getMonthsThai(): array {
		return [
			'มกราคม',
			'กุมภาพันธ์',
			'มีนาคม',
			'เมษายน',
			'พฤษภาคม',
			'มิถุนายน',
			'กรกฎาคม',
			'สิงหาคม',
			'กันยายน',
			'ตุลาคม',
			'พฤศจิกายน',
			'ธันวาคม',
		];
	}
}
