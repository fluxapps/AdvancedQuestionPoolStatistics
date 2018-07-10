<?php

class ilAdvancedQuestionPoolStatisticsAlertFormGUI extends ilPropertyFormGUI {

	/**
	 * @var ilAdvancedTestStatisticsPlugin
	 */
	protected $pl;
	/**
	 * @var ilCtrl
	 */
	protected $ctrl;
	/**
	 * @var ilAdvancedTestStatisticsSettingsGUI
	 */
	protected $parent_gui;
	/**
	 * @var xatsFilter
	 */
	protected $object;
	protected $operators = array( '>', '<', '>=', '<=', '!=', '==' );
	protected $extendedFields = array(
		"avg_points_finished" => "Average Points finished tests",
		"avg_result_passed" => "Average result passed tests",
		"avg_result_finished" => "Average result(%) finished tests",
		"avg_result_finished_run_one" => "Average result(%) passed tests (Run 1)",
		"avg_result_passed_run_one" => "Average result(%) finished tests (Run 1)",
		"avg_result_passed_run_two" => "Average result(%) passed tests (Run 2)",
		"avg_result_finished_run_two" => "Average result(%) finished tests (Run 2)"
	);


	/**
	 * ilAdvancedTestStatisticsAlertFormGUI constructor.
	 *
	 * @param            $parent_gui
	 */
	public function __construct($parent_gui) {
		global $ilCtrl, $tpl;

		$this->ctrl = $ilCtrl;
		$this->tpl = $tpl;
		$this->pl = ilAdvancedQuestionPoolStatisticsPlugin::getInstance();
		$this->ref_id = $_GET['ref_id'];
		$this->parent_gui = $parent_gui;
		$this->setFormAction($this->ctrl->getFormAction($this->parent_gui));


		parent::__construct();

		$this->initForm();
	}


	public function initForm() {
		$this->setTarget('_top');
		$this->initButtons();

		$alerts = new ilAlertFormGUI();
		$alerts->appendToForm($this);
	}


	public function initButtons() {
		$this->ctrl->setParameterByClass(ilAdvancedQuestionPoolStatisticsGUI::class, 'ref_id', $this->ref_id);
		$this->addCommandButton(ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_CREATE_TRIGGER, $this->pl->txt('form_update'));
		$this->addCommandButton(ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_CANCEL, $this->pl->txt('form_cancel'));
	}


	public function save() {
		if (!$this->fill()) {
			return false;
		}

		$triggers = xatsTriggers::get();
		foreach ($triggers as $trigger) {
			$trigger->delete();
		}

		return true;
	}


	public function fill() {
		if (!$this->checkInput()) {
			return false;
		}

		return true;
	}
}