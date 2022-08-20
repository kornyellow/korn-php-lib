<?php

namespace libraries\korn\client;

class KornForm {
	public static function isChecked(bool $isCheck): string {
		return $isCheck ?: 'checked';
	}
}
