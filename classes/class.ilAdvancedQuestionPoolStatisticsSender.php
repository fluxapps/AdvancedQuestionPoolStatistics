<?php




class ilAdvancedQuestionPoolStatisticsSender {


	Const NOTIFICATIONNAME = 'statisticsPoolNotification';


	public function createNotification($course_id,$usr_id,$ref_id,$trigger){

		$sender = new srNotificationInternalMailSender(new ilObjUser(6), new ilObjUser($usr_id));


		$placeholders = array('course' => new ilObjCourse($course_id,true),'trigger' => $trigger, 'pool' => new ilObjQuestionPool($ref_id,true));

		try{
			$notification = srNotification::getInstanceByName(self::NOTIFICATIONNAME);
			$notification->send($sender,$placeholders);
		}

		catch (Exception $e){
			return $e;
		}
	}

}