<?php

namespace libraries\korn\client;

use libraries\korn\KornConfig;

class KornHeader {
	private static string $title       = "หน้าหลัก";
	private static string $description = "";
	private static string $abstract    = "";
	private static string $keywords    = "";

	public static function getWebsiteName(): string {
		return KornConfig::$websiteName;
	}
	public static function getTitle(): string {
		if (self::$title !== 'หน้าหลัก') {
			self::$title .= ' · '.self::getWebsiteName();
		}
		else {
			self::$title = self::getWebsiteName();
		}
		return self::$title;
	}
	public static function getDescription(): string {
		return self::$description;
	}
	public static function getAbstract(): string {
		return self::$abstract;
	}
	public static function getKeywords(): string {
		return self::$keywords;
	}
	public static function getAuthor(): string {
		return KornConfig::$websiteAuthor;
	}

	public static function constructHeader($title = null, $description = null, $abstract = null): void {
		self::$title = $title ?? self::$title;
		self::$description = $description ?? self::$description;
		self::$abstract = $abstract ?? self::$abstract;

		include('templates/header.php');
	}
}
