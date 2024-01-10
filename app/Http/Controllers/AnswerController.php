<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\User;
use App\Models\UserQuiz;
use App\Traits\BaseApp;
use App\Utilities\AnswerUtility;
use Exception;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    use BaseApp;

    public function processAnswers(Request $request)
    {
        $error_code = 'ARPAS200';
        $data = null;

        try {
            $email = $request->email;
            $quiz_id = $request->quiz_id;

            $userTable = new User;
            $user = $userTable->exists($email);

            if ($user) {
                $user_id = $user->id;
                $userQuizTable = new UserQuiz;
                $userQuizTable->addQuizToUser($quiz_id, $user_id);

                $answers = $request->answers;
                $answerUtility = new AnswerUtility;
                $answers_ids = $answerUtility->createAnswers($answers, $user_id);
                if (count($answers_ids) <= 0) {
                    $error_code = 'ARPA400';
                } else {
                    $data = $answers_ids;
                }
            } else {
                $error_code = "ARPA401";
            }
        } catch (Exception $e) {
            $error_code = "ARPA500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }


    public function processUpdateAnswers(Request $request)
    {
        $error_code = 'ARPUA200';
        $data = null;

        try {
            $email = $request->email;
            $quiz_id = $request->quiz_id;

            $userTable = new User;
            $user = $userTable->exists($email);

            if ($user) {
                $user_id = $user->id;
                $userQuizTable = new UserQuiz;
                $userQuizTable->addQuizToUser($quiz_id, $user_id);

                $answers = $request->answers;
                $answerUtility = new AnswerUtility;
                $answers_ids = $answerUtility->createAnswers($answers, $user_id);
                if (count($answers_ids) <= 0) {
                    $error_code = 'ARPUA400';
                } else {
                    $data = $answers_ids;
                }
            } else {
                $error_code = "ARPUA401";
            }
        } catch (Exception $e) {
            $error_code = "ARPUA500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }


    public function getAnswersByQuiz($quiz_id)
    {
        $error_code = 'ARGABQ00';
        $data = null;
        try {
            $answerTable = new Answer;
            $answers = $answerTable->getAnswersByQuiz($quiz_id);

            $total_points = 0;
            $correct_answers = 0;
            $wrong_answers = 0;
            foreach ($answers as $value) {
                $total_points += $value->points;
                if ($value->points) {
                    $correct_answers++;
                } else {
                    $wrong_answers++;
                }
            }
            if (count($answers) <= 0) {
                $error_code = 'ARGABQ400';
            } else {
                $data = array('total_points' => $total_points, 'correct_answers' => $correct_answers, 'wrong_answers' => $wrong_answers, 'answers' => $answers);
            }
        } catch (Exception $e) {
            $error_code = "ARGABQ500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }
}
