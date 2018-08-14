<?php




class ilAdvancedQuestionPoolStatisticsSender {


	Const NOTIFICATIONNAME = 'statisticsPoolNotification';


	public function createNotification($course_id, $usr_id, $ref_id, $trigger, $trigger_values){
        global $ilCtrl;
        $sender = new srNotificationInternalMailSender(new ilObjUser(6), new ilObjUser($usr_id));
        $qst_pool = new ilObjQuestionPool($ref_id,true);

        $ilCtrl->setParameterByClass('ilObjQuestionPoolGUI', 'ref_id', $trigger->getRefId());
        $placeholders = array(
            'course' => new ilObjCourse($course_id,true),
            'qst_pool' => $qst_pool,
            'qst_pool_url' => ILIAS_HTTP_PATH . '/' . $ilCtrl->getLinkTargetByClass('ilObjQuestionPoolGUI'),
            'trigger' => $trigger,
            'trigger_values' => $trigger_values
        );

        try {
            $notification = srNotification::getInstanceByName(self::NOTIFICATIONNAME);
            $notification->send($sender,$placeholders);
        }

        catch (Exception $e){
            return $e;
        }
	}

}