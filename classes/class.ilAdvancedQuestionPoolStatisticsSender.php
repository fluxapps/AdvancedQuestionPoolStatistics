<?php

use srag\Notifications4Plugin\Notifications4Plugins\Utils\Notifications4PluginTrait;

class ilAdvancedQuestionPoolStatisticsSender
{

    use Notifications4PluginTrait;

    const NOTIFICATIONNAME = 'statisticsPoolNotification';

    /**
     * @param $course_id
     * @param $usr_id
     * @param $ref_id
     * @param $trigger
     * @param $trigger_values
     * @throws ilException
     */
    public function createNotification($course_id, $usr_id, $ref_id, $trigger, $trigger_values)
    {
        if (!$trigger->getUserId()) {
            throw new ilException('no recipient user id given');
        }
        $sender = self::sender()->factory()->internalMail(new ilObjUser(6), new ilObjUser($trigger->getUserId()));
        $qst_pool = new ilObjQuestionPool($ref_id, true);

        $placeholders = array(
            'course' => new ilObjCourse($course_id, true),
            'qst_pool' => $qst_pool,
            'qst_pool_url' => ILIAS_HTTP_PATH . '/goto.php?target=qpl_' . $ref_id . '&client_id=' . CLIENT_ID,
            'trigger' => $trigger,
            'trigger_values' => $trigger_values
        );

        $notification = self::notification(
            'srag\Plugins\Notifications4Plugins\Notification\Notification',
            'srag\Plugins\Notifications4Plugins\Notification\Language\NotificationLanguage'
        )->getNotificationByName(self::NOTIFICATIONNAME);
        self::sender()->send($sender, $notification, $placeholders);
    }

}