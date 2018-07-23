<?php

//TODO ACCESS CONTROL
class ilAdvancedQuestionPoolStatisticsAccess {

	/**
	 * @var int
	 */
	protected $ref_id;


	public function __construct($ref_id) {
		$this->pl = ilAdvancedTestStatisticsPlugin::getInstance();
		$this->ref_id = $ref_id;
	}


	public function hasCurrentUserAlertAccess() {
		global $ilAccess;

		if ($ilAccess->checkAccess("statistics", "", $this->ref_id)) {
			return true;
		}

		return false;
	}
}