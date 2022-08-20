<?php

namespace libraries\korn\server\database;

use mysqli;
use libraries\korn\KornConfig;
use libraries\korn\utils\KornDebug;
use libraries\korn\utils\KornNetwork;
use libraries\korn\utils\KornCredential;

class KornConnection {
	private static mysqli|null $connection = null;

	public static function getDatabase(): mysqli {
		if (KornNetwork::isLocalHost())
			return self::getConnection('p:localhost', 'root', '', KornConfig::$databaseBeta);

		return self::getConnection(
			'p:localhost',
			KornCredential::getDatabaseUsername(),
			KornCredential::getDatabasePassword(),
			KornConfig::$databaseProduction
		);
	}
	private static function getConnection(
		string $hostName,
		string $username,
		string $password,
		string $databaseName
	): mysqli {
		if (self::$connection)
			return self::$connection;

		$connection = mysqli_init();

		if (!$connection->real_connect($hostName, $username, $password, $databaseName))
			KornDebug::printError('ERROR: MySQL connection error', mysqli_connect_error());
		$connection->set_charset('utf8');

		self::$connection = $connection;
		return $connection;
	}
}
