<?php

class ilAdvancedQuestionPoolStatisticsAlertTableGUI extends ilTable2GUI {

	/**
	 * @var ilTabsGUI
	 */
	protected $tabs;
	/**
	 * @var ilCtrl
	 */
	protected $ctrl;
	protected $parent_obj;
	/**
	 * @var ilAdvancedQuestionPoolStatisticsPlugin
	 */
	protected $pl;
	/**
	 * @var object
	 */
	protected $object;
	/**
	 * @var ilToolbarGUI
	 */
	protected $toolbar;


	public function __construct($a_parent_obj, $a_parent_cmd = "") {
		global $ilCtrl, $tabs, $ilToolbar;

		$this->ctrl = $ilCtrl;
		$this->tabs = $tabs;
		$this->toolbar = $ilToolbar;
		$this->pl = ilAdvancedQuestionPoolStatisticsPlugin::getInstance();
		$this->ref_id = $_GET['ref_id'];

		parent::__construct($a_parent_obj, $a_parent_cmd);

		$this->getEnableHeader();
		$this->setRowTemplate('./Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/AdvancedTestStatistics/templates/default/tpl.row_template.html');
		$this->setFormAction($this->ctrl->getFormAction($a_parent_obj));

		$b_print = ilLinkButton::getInstance();
		$b_print->setCaption($this->pl->txt('header_btn_add'), false);
		$b_print->setUrl($this->ctrl->getLinkTargetByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class, ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_ADD_TRIGGER));
		$this->toolbar->addButtonInstance($b_print);


		$this->addColumns();
		$this->parseData();
	}


	function getSelectableColumns() {
		$cols = array();

		$cols['id'] = array( 'txt' => $this->pl->txt('cols_id'), 'default' => true, 'width' => 'auto', 'sort_field' => 'id' );
		$cols['trigger'] = array( 'txt' => $this->pl->txt('cols_title'), 'default' => true, 'width' => 'auto', 'sort_field' => 'title' );
		$cols['operator'] = array(
			'txt' => $this->pl->txt('cols_operator'),
			'default' => true,
			'width' => 'auto',
			'sort_field' => 'description'
		);
		$cols['value'] = array( 'txt' => $this->pl->txt('cols_value'), 'default' => true, 'width' => 'auto', 'sort_field' => 'value' );
		$cols['inform'] = array( 'txt' => $this->pl->txt('cols_inform'), 'default' => true, 'width' => 'auto', 'sort_field' => 'inform' );
		$cols['usercomplete'] = array(
			'txt' => $this->pl->txt('cols_usercomplete'),
			'default' => true,
			'width' => 'auto',
			'sort_field' => 'usercomplete'
		);
		$cols['date'] = array( 'txt' => $this->pl->txt('cols_date'), 'default' => true, 'width' => 'auto', 'sort_field' => 'date' );
		$cols['interval'] = array( 'txt' => $this->pl->txt('cols_interval'), 'default' => true, 'width' => 'auto', 'sort_field' => 'interval' );

		return $cols;
	}


	private function addColumns() {

		foreach ($this->getSelectableColumns() as $k => $v) {
			if ($this->isColumnSelected($k)) {
				if (isset($v['sort_field'])) {
					$sort = $v['sort_field'];
				} else {
					$sort = NULL;
				}
				$this->addColumn($v['txt'], $sort, $v['width']);
			}
		}
		if (!$this->getExportMode()) {
			$this->addColumn($this->pl->txt('cols_actions'));
		}
	}


	/**
	 * @return array
	 * @var $triggers xatsTriggers
	 */
	public function parseData() {
		$triggers = xaqsTriggers::where(array('ref_id' => $this->ref_id))->get();

		/** @var xaqsTriggers $trigger */
        foreach ($triggers as $trigger) {

			$row = array();
			$row['id'] = $trigger->getId();

			$t = $this->pl->txt($trigger->getTriggerName());
			$row['trigger'] = $t;

			$operator = ilAdvancedQuestionPoolStatisticsConstantTranslator::getOperatorforKey($trigger->getOperator());
			$row['operator'] = $operator;

			$row['value'] = $trigger->getValue();

			$user = new ilObjUser($trigger->getUserId());
			$row['inform'] = $user->getLogin();


			$row['usercomplete'] = $trigger->getUserPercentage();

			$date = $trigger->getDatesender();
			$row['date'] = date("d.m.Y",$date);


			$interval = ilAdvancedQuestionPoolStatisticsConstantTranslator::getIntervalforKey($trigger->getIntervalls());
			$row['interval'] = $interval;

			$rows[] = $row;
		}
		$this->setData($rows);

		return $rows;
	}


	public function fillRow($a_set) {

		foreach ($this->getSelectableColumns() as $k => $v) {
			if ($this->isColumnSelected($k)) {
				if (!is_null($a_set[$k])) {
					$this->tpl->setCurrentBlock('td');
					$this->tpl->setVariable('VALUE', $a_set[$k]);
					$this->tpl->parseCurrentBlock();
				} else {
					$this->tpl->setCurrentBlock('td');
					$this->tpl->setVariable('VALUE', '&nbsp;');
					$this->tpl->parseCurrentBlock();
				}
			}
		}
		$current_selection_list = new ilAdvancedSelectionListGUI();
		$current_selection_list->setListTitle($this->pl->txt('cols_actions'));
		$current_selection_list->setId('_actions' . $a_set['id']);
		$current_selection_list->setUseImages(false);
		$this->ctrl->setParameterByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class, 'trigger_id', $a_set['id']);

		$current_selection_list->addItem($this->pl->txt('list_trigger_trigger'), ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_TRIGGER_TRIGGER,$this->ctrl->getLinkTargetByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class,ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_TRIGGER_TRIGGER));
		$current_selection_list->addItem($this->pl->txt('list_edit_trigger'), ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_EDIT_TRIGGER, $this->ctrl->getLinkTargetByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class, ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_EDIT_TRIGGER));
		$current_selection_list->addItem($this->pl->txt('list_delete_trigger'), ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_DELETE, $this->ctrl->getLinkTargetByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class, ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_DELETE));
		$current_selection_list->addItem($this->pl->txt('list_copy_trigger'), ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_COPY_TRIGGER,$this->ctrl->getLinkTargetByClass(ilAdvancedQuestionPoolStatisticsSettingsGUI::class,ilAdvancedQuestionPoolStatisticsSettingsGUI::CMD_COPY_TRIGGER));

		$this->tpl->setVariable('ACTIONS', $current_selection_list->getHTML());
		$this->tpl->parseCurrentBlock();
	}
}