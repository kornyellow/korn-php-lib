<?php

namespace libraries\korn\server\query\builder;

use libraries\korn\server\database\KornConnection;

class KornQuerySelect implements KornQueryBuilder {
	private string $table;

	private string|null $where        = null;
	private string|null $order        = null;
	private bool        $isDescending = false;
	private int|null    $limit        = null;
	private int|null    $offset       = null;

	public function __construct(string $table) {
		$this->table = $table;
	}

	public function where(string $column, string $value) {
		$connection = KornConnection::getDatabase();
		$this->where = mysqli_real_escape_string($connection, $column);
		$this->where .= '=';
		$this->where .= '"'.mysqli_real_escape_string($connection, $value).'"';
	}
	public function whereRaw(string $where) {
		$this->where = $where;
	}
	public function sortByColumn(string $column) {
		$this->order = $column;
	}
	public function sortDescending(bool $bool) {
		$this->isDescending = $bool;
	}
	public function limit(int $limit) {
		$this->limit = $limit;
	}
	public function offset(int $offset) {
		$this->offset = $offset;
	}
	public function build(): string {
		$build = 'SELECT * FROM `'.$this->table.'` ';

		if ($this->where)
			$build .= 'WHERE '.$this->where.' ';

		if ($this->order)
			$build .= 'ORDER BY '.$this->table.'.'.$this->order.' ';

		if ($this->isDescending)
			$build .= 'DESC ';


		if ($this->limit > 0) {
			$build .= 'LIMIT ';
			if ($this->offset == 0)
				$build .= $this->limit;
			else if ($this->offset > 0)
				$build .= $this->offset.', '.$this->limit;
		}

		return $build;
	}
}
