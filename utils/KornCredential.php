<?php

namespace libraries\korn\utils;

class KornCredential {
	public static function getDatabaseUsername(): string {
		return KornFile::getStringFromFile('/.CREDENTIAL/database', true)[0];
	}
	public static function getDatabasePassword(): string {
		return KornFile::getStringFromFile('/.CREDENTIAL/database', true)[1];
	}
}
