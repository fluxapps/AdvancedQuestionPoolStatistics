<?php

class xaqsTriggers extends ActiveRecord {

	const TABLE_NAME = 'xaqs_triggers';
	/**
	 * @var int
	 *
	 * @con_is_primary  true
	 * @con_sequence    true
	 * @con_is_notnull  true
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $id;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $ref_id;
	/**
	 * @var String
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_length      256
	 */
	protected $trigger_name;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $operator;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $value;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $user_id;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 */
	protected $user_percentage;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_length      256
	 */
	protected $datesender;
	/**
	 * @var string
	 *
	 * @con_has_field   true
	 * @con_fieldtype   text
	 * @con_length      256
	 */
	protected $intervalls;
	/**
	 * @var int
	 *
	 * @con_has_field   true
	 * @con_fieldtype   integer
	 * @con_length      8
	 *
	 */
	protected $lastrun;




	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * @return int
	 */
	public function getRefId() {
		return $this->ref_id;
	}


	/**
	 * @param int $ref_id
	 */
	public function setRefId($ref_id) {
		$this->ref_id = $ref_id;
	}


	/**
	 * @return String
	 */
	public function getTriggerName() {
		return $this->trigger_name;
	}


	/**
	 * @param String $trigger_name
	 */
	public function setTriggerName($trigger_name) {
		$this->trigger_name = $trigger_name;
	}

    /**
     * @return string
     */
    public function getTriggerNameFormatted() {
        return ilAdvancedTestStatisticsPlugin::getInstance()->txt($this->trigger_name);
    }

	/**
	 * @return int
	 */
	public function getOperator() {
		return $this->operator;
	}


	/**
	 * @param int $operator
	 */
	public function setOperator($operator) {
		$this->operator = $operator;
	}

    /**
     * return String returns <, >, = etc.
     */
    public function getOperatorFormatted() {
        return ilAdvancedTestStatisticsConstantTranslator::getOperatorforKey($this->getOperator());
    }

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}


	/**
	 * @param int $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}


	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->user_id;
	}


	/**
	 * @return int
	 */
	public function getUserPercentage() {
		return $this->user_percentage;
	}


	/**
	 * @param int $user_percentage
	 */
	public function setUserPercentage($user_percentage) {
		$this->user_percentage = $user_percentage;
	}


	/**
	 * @return string
	 */
	public function getDatesender() {
		return $this->datesender;
	}


	/**
	 * @param string $datesender
	 */
	public function setDatesender($datesender) {
		$this->datesender = $datesender;
	}


	/**
	 * @return int
	 */
	public function getLastRun() {
		return $this->lastrun;
	}


	/**
	 * @param int $lastRun
	 */
	public function setLastRun($lastRun) {
		$this->lastrun = $lastRun;
	}


	/**
	 * @return string
	 */
	public function getIntervalls() {
		return $this->intervalls;
	}


	/**
	 * @param string $intervalls
	 */
	public function setIntervalls($intervalls) {
		$this->intervalls = $intervalls;
	}


	/**
	 * @param int $user_id
	 */
	public function setUserId($user_id) {
		$this->user_id = $user_id;
	}


	public static function returnDbTableName() {
		return self::TABLE_NAME;
	}
}