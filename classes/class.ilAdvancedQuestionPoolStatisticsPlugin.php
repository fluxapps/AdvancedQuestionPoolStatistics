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

    /**
     * @return ilObjCourse
     * @throws Exception
     */
    public function getParentCourse($ref_id = 0) {
        $ref_id = $ref_id ? $ref_id : $_GET['ref_id'];
        require_once 'Services/Object/classes/class.ilObjectFactory.php';
        $parent = ilObjectFactory::getInstanceByRefId($this->getParentCourseId($ref_id));

        return $parent;
    }


    /**
     * @param $ref_id
     *
     * @return int
     * @throws Exception
     */
    public function getParentCourseId($ref_id) {
        global $tree;
        while (!in_array(ilObjCourse::_lookupType($ref_id, true), array( 'crs', 'grp' ))) {
            if ($ref_id == 1 || !$ref_id) {
                throw new Exception("Parent of ref id {$ref_id} is neither course nor group.");
            }
            $ref_id = $tree->getParentId($ref_id);
        }

        return $ref_id;
    }

}

?>