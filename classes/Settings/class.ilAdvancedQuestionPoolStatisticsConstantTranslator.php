<?php

/**
 * Class ilAdvancedQuestionPoolStatisticsConstantTranslator
 *
 * @author Silas Stulz <sst@studer-raimann.ch>
 *
 * Functions to translate values from the DB to more human readable signs
 */
class ilAdvancedQuestionPoolStatisticsConstantTranslator {


	public function __construct() {
	}

	public static function getOperatorforKey($key){
		$operators = array( 0 => '>',1 => '<',2 => '>=',3 => '<=',4 => '!=',5 => '==' );
		return $operators[$key];
	}

	public static function getExtendedFieldforKey($key,$ref_id){
		$extendedFields = array(
            0 => 'avg_points_finished',
            1 => "avg_result_passed",
            2 => "avg_result_finished",
            3 => "avg_result_passed_run_one",
            4 => "avg_result_finished_run_one",
            5 => "avg_result_passed_run_two",
            6 => "avg_result_finished_run_two",
            7 =>'nr_participants_started',
            8 =>'nr_tests_finished',
            9 =>'avg_test_time',
            10 =>'nr_tests_passed',
            11 =>'avg_points_passed',
            12 => 'avg_passed_test_time',
		);

		$qstpl = new ilObjQuestionPool($ref_id);
		$question_ids = $qstpl->getAllQuestions();
        $questions = $qstpl->getQuestionDetails($question_ids);

        $question_array = array();
		foreach ($questions as $question) {
            $question_array[$question['question_id']] = $question['title'];
		}

        return in_array($key, $extendedFields) ? ilAdvancedQuestionPoolStatisticsPlugin::getInstance()->txt($key) : $question_array[$key];
    }

	public static function getIntervalforKey($key){
		$interval_options = array(0 => 'daily',1 => 'weekly', 2 => 'monthly');
		return $interval_options[$key];
	}



	public static function getValues($key,$ref_id){
		$class = new ilAdvancedTestStatisticsAggResults();
		$id = $class->getTstidforRefid($ref_id);

		switch ($key){
            case 'avg_points_finished': return $class->getAveragePointsFinshedTests($id,$ref_id);
            case "avg_result_passed": return $class->getAverageResultPassedTests($id,$ref_id);
            case "avg_result_finished": return $class->getAverageResultFinishedTests($id,$ref_id);
            case "avg_result_passed_run_one": return $class->getAverageResultPassedTestsRunOne($ref_id);
            case "avg_result_finished_run_one": return $class->getAverageResultFinishedTestsRunOne($ref_id);
            case "avg_result_passed_run_two": return $class->getAverageResultPassedTestsRunTwo($ref_id);
            case "avg_result_finished_run_two": return $class->getAverageResultFinishedTestsRunTwo($ref_id);
            case 'nr_participants_started': return $class->getTotalNumberStartedTest($ref_id);
            case 'nr_tests_finished': return $class->getTotalFinishedTests($ref_id);
            case 'avg_test_time': return $class->getAvgTestTime($ref_id,$id);
            case 'nr_tests_passed': return $class->getTotalPassedTests($ref_id);
            case 'avg_points_passed': return $class->getAveragePointsPassedTests($ref_id);
            case 'avg_passed_test_time': return $class->getAverageTimePassedTests($ref_id);
			default: return false;
		}









	}


}