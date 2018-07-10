<?php

require_once __DIR__ . '/../vendor/autoload.php';
/**
 *
 * @author Silas Stulz <sst@studer-raimann.ch>
 * @version $Id$
 *
 * @ilCtrl_IsCalledBy ilAdvancedQuestionPoolStatisticsPlugin: ilUIPluginRouterGUI
 */
class ilAdvancedQuestionPoolStatisticsPlugin extends ilUserInterfaceHookPlugin
{
	const CMD_ADD_USER_AUTO_COMPLETE = 'addUserAutoComplete';
	/**
	 * @var ilAdvancedQuestionPoolStatisticsPlugin
	 */
	protected static $instance;

	function getPluginName()
	{
		return "AdvancedQuestionPoolStatistics";
	}

	public static function getInstance(){

		if(is_null(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}



	/**
	 * async auto complete method for user filter in overview
	 */
	public function addUserAutoComplete() {
		include_once './Services/User/classes/class.ilUserAutoComplete.php';
		$auto = new ilUserAutoComplete();
		$auto->setSearchFields(array( 'usr_id','login', 'firstname', 'lastname' ));
		$auto->setResultField('login');
		$auto->enableFieldSearchableCheck(false);
		$auto->setMoreLinkAvailable(true);

		if (($_REQUEST['fetchall'])) {
			$auto->setLimit(ilUserAutoComplete::MAX_ENTRIES);
		}

		$list = $auto->getList($_REQUEST['term']);

		echo $list;
		exit();
	}

}

?>