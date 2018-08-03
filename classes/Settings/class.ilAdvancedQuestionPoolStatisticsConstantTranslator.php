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
			0 => "Average Points finished tests",
			1 => "Average result passed tests",
			2 => "Average result(%) finished tests",
			3 => "Average result(%) passed tests (Run 1)",
			4 => "Average result(%) finished tests (Run 1)",
			5 => "Average result(%) passed tests (Run 2)",
			6 => "Average result(%) finished tests (Run 2)",
			7 =>'Total number of participants who started the test',
			8 =>'Total finished tests (Participants that used up all possible passes)',
			9 =>'Average test processing time',
			10 =>'Total passed tests',
			11 =>'Average points of passed tests',
			12 => 'Average processing time of all passed tests',
		);

		$test = new ilObjQuestionPool($ref_id);
		$questions = $test->getAllQuestions();

		foreach ($questions as $question) {
			$extendedFields[$question['question_id']] = $question['title'];
		}


		return $extendedFields[$key];

	}

	public static function getIntervalforKey($key){
		$interval_options = array(0 => 'daily',1 => 'weekly', 2 => 'monthly');
		return $interval_options[$key];
	}



	public static function getValues($key,$ref_id){
		$class = new ilAdvancedTestStatisticsAggResults();
		$id = $class->getTstidforRefid($ref_id);

		switch ($key){
			case 0: return $class->getAveragePointsFinshedTests($id,$ref_id);
			case 1: return $class->getAverageResultPassedTests($id,$ref_id);
			case 2: return $class->getAverageResultFinishedTests($id,$ref_id);
			case 3: return $class->getAverageResultPassedTestsRunOne($ref_id);
			case 4: return $class->getAverageResultFinishedTestsRunOne($ref_id);
			case 5: return $class->getAverageResultPassedTestsRunTwo($ref_id);
			case 6: return $class->getAverageResultPassedTestsRunTwo($ref_id);
			case 7: return $class->getTotalNumberStartedTest($ref_id);
			case 8: return $class->getTotalFinishedTests($ref_id);
			case 9: return $class->getAvgTestTime($ref_id,$id);
			case 10: return $class->getTotalPassedTests($ref_id);
			case 11: return $class->getAveragePointsPassedTests($ref_id);
			case 12: return $class->getAverageTimePassedTests($ref_id);
			default: return false;
		}









	}


}