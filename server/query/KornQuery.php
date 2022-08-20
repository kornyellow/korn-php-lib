<?php

namespace libraries\korn\server\query;

use mysqli_result;
use libraries\korn\server\query\builder\KornQueryBuilder;

class KornQuery {
	private array $fieldsName = [];

	private mysqli_result|null $result = null;

	private int $affectedRows;
	private int $insertedID;
	public function __construct(KornQueryBuilder $queryBuilder = null) {
		if ($queryBuilder)
			self::query($queryBuilder->build());
	}
	private function query(string $query): void {
		$statement = KornStatement::prepare($query);

		$this->affectedRows = $statement->affected_rows;
		$this->insertedID   = $statement->insert_id;

		$this->result = $statement->get_result();

		$fields = $this->result->fetch_fields();
		foreach ($fields as $field)
			$this->fieldsName[] = $field->name;
	}
	public function affectedRows(): int {
		return $this->affectedRows;
	}
	public function insertedID(): int {
		return $this->insertedID;
	}
	public function nextBind(array $fields): array|bool {
		if (!$this->result)
			return false;

		$result = $this->result->fetch_assoc();

		if (!$result)
			return false;

		foreach ($this->fieldsName as $fieldName)
			$fields[$fieldName] = $result[$fieldName];

		return $fields;
	}
}
