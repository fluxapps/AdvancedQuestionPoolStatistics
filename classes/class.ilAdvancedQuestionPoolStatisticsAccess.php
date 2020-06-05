<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once'./libs/composer/vendor/autoload.php';

class ilAdvancedQuestionPoolStatisticsAccess {

	/**
	 * @var int
	 */
	protected $ref_id;

    /**
     * ilAdvancedQuestionPoolStatisticsAccess constructor.
     * @param $ref_id
     */
	public function __construct($ref_id) {
		$this->pl = ilAdvancedQuestionPoolStatisticsPlugin::getInstance();
		$this->ref_id = $ref_id;
	}

    /**
     * @return bool
     */
	public function hasCurrentUserAlertAccess() {
		global $ilAccess;

		if ($ilAccess->checkAccess("write", "", $this->ref_id)) {
			return true;
		}

		return false;
	}
}