<?php
/**
 * Class ilAdvancedQuestionPoolStatisticsGUI
 *
 * @author  Silas Stulz <sst@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy ilAdvancedQuestionPoolStatisticsGUI: ilUIPluginRouterGUI, ilObjTestGUI
 */
class ilAdvancedQuestionPoolStatisticsGUI {

	/**
	 * @var ilCtrl
	 */
	protected $ctrl;
	/**
	 * @var ilTemplate
	 */
	protected $tpl;

	public function __construct() {
		global $ilCtrl,$tpl;

		$this->ctrl = $ilCtrl;
		$this->tpl = $tpl;
		$this->ref_id = $_GET['ref_id'];
		//$this->obj = ilObjectFactory::getInstanceByRefId($this->ref_id);

	}


	public function executeCommand(){
		$nextClass = $this->ctrl->getNextClass();

		switch ($nextClass){
			case 'iladvancedquestionpoolstatisticssettingsgui':
				$ilAdvancedQuestionPoolStatisticsSettingsGUI = new ilAdvancedQuestionPoolStatisticsSettingsGUI();
				$this->ctrl->forwardCommand($ilAdvancedQuestionPoolStatisticsSettingsGUI);
				break;
			default: $cmd = $this->ctrl->getCmd();
				$this->{$cmd}();
		}
	}
}