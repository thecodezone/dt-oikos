<?php

namespace DT\Oikos\Conditions;

use DT\Oikos\CodeZone\Router\Conditions\Condition;

class Frontend implements Condition {

	/**
	 * Test if the path is a frontend path.
	 *
	 * @return bool Returns true if the path is a frontend path.
	 */
	public function test(): bool {
		return ! is_admin();
	}
}