<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @author  Silas Stulz <sst@studer-raimann.ch>
 * @version $Id$
 * @ingroup ServicesUIComponent
 */
class ilAdvancedQuestionPoolStatisticsUIHookGUI extends ilUIHookPluginGUI {

	/**
	 * @var ilCtrl
	 */
	protected $ctrl;
	/**
	 * @var ilAdvancedTestStatisticsPlugin
	 */
	protected $pl;


	public function __construct() {
		global $ilCtrl;

		$this->pl = ilAdvancedQuestionPoolStatisticsPlugin::getInstance();
		$this->ctrl = $ilCtrl;
		$this->ref_id = $_GET['ref_id'];
		$this->access = new ilAdvancedQuestionPoolStatisticsAccess($this->ref_id);
	}


	function getHTML($a_comp, $a_part, $a_par = array()) {

	}


	/**
	 * Modify GUI objects, before they generate ouput
	 *
	 * @param string $a_comp component
	 * @param string $a_part string that identifies the part of the UI that is handled
	 * @param string $a_par  array of parameters (depend on $a_comp and $a_part)
	 */
	function modifyGUI($a_comp, $a_part, $a_par = array()) {
		/**
		 * @var ilTabsGUI $tabs
		 */
		if ($a_part == 'sub_tabs') {
			if ($this->checkTest()) {
				$tabs = $a_par['tabs'];
				$this->ctrl->setParameterByClass('ilAdvancedQuestionPoolStatisticsSettingsGUI', 'ref_id',$this->ref_id);
				//	$tabs->removeSubTab('tst_results_aggregated');
				if ($this->access->hasCurrentUserAlertAccess()) {
					$link = $this->ctrl->getLinkTargetByClass(array(
						'ilUIPluginRouterGUI',
						'ilAdvancedQuestionPoolStatisticsGUI',
						'ilAdvancedQuestionPoolStatisticsSettingsGUI'
					), ilAdvancedTestStatisticsSettingsGUI::CMD_DISPLAY_TRIGGERS);
					$tabs->addTab("alerts", "Alerts", $link);
				}
			}
		}
	}


	function checkTest() {
		foreach ($this->ctrl->getCallHistory() as $GUIClassesArray) {
			if ($GUIClassesArray['class'] == 'ilObjQuestionPoolGUI') {
				return true;
			}
		}

		return false;
	}
}

?>