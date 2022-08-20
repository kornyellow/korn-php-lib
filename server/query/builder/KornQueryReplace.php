<?php

namespace libraries\korn\server\query\builder;

use libraries\korn\server\query\KornStatement;

class KornQueryReplace implements KornQueryBuilder {
	private string $table;
	private array  $values = [];

	public function __construct(string $table) {
		$this->table = $table;
	}

	public function values(array $values): void {
		$this->values = $values;
	}

	public function build(): string {
		$fieldsName = KornStatement::getFieldsName($this->table);
		if (count($this->values) != count($fieldsName))
			return '';

		$build = 'REPLACE INTO `'.$this->table.'` ';

		$build .= '('.implode(', ', $fieldsName).') ';
		$build .= 'values ("'.implode('", "', $this->values).'")';

		return $build;
	}
}
