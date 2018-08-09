<?php

/**
 * Class ilAdvancedQuestionPoolStatisticsConstantTranslator
 *
 * @author Silas Stulz <sst@studer-raimann.ch>
 *
 * Functions to translate values from the DB to more human readable signs
 */
class ilAdvancedQuestionPoolStatisticsConstantTranslator {


    /**
     * ilAdvancedQuestionPoolStatisticsConstantTranslator constructor.
     */
    public function __construct() {
	}

    /**
     * @param $key
     * @return mixed
     */
    public static function getOperatorforKey($key){
		$operators = array( 0 => '>',1 => '<',2 => '>=',3 => '<=',4 => '!=',5 => '==' );
		return $operators[$key];
	}

    /**
     * @param $key
     * @param $ref_id
     * @return mixed
     */
    public static function getQuestionForId($key, $ref_id){
		$qstpl = new ilObjQuestionPool($ref_id);
		$question_ids = $qstpl->getAllQuestions();
        $questions = $qstpl->getQuestionDetails($question_ids);

        $question_array = array();
		foreach ($questions as $question) {
            $question_array[$question['question_id']] = $question['title'];
		}

        return $question_array[$key];
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getIntervalforKey($key){
		$interval_options = array(0 => 'daily',1 => 'weekly', 2 => 'monthly');
		return $interval_options[$key];
	}


    /**
     * the user threshold is checked in this method
     *
     * @param $trigger xaqsTriggers
     * @param $ref_id
     * @return array
     */
	public static function getValues($trigger){
        $qst_pool = new ilObjQuestionPool($trigger->getRefId());
        $question_ids = $qst_pool->getAllQuestions();

        $valuesreached = array();
        foreach ($question_ids as $qst_id) {
            if (assQuestion::_getTotalAnswers($qst_id) >= $trigger->getCompletedThreshold()) {
                $valuesreached[$qst_id] = assQuestion::_getTotalRightAnswers($qst_id) * 100;
            }
        }

        return $valuesreached;
	}


}