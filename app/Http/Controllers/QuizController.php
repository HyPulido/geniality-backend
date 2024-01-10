<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\UserQuiz;
use App\Services\OpentdbService;
use App\Traits\BaseApp;
use App\Utilities\QuestionUtility;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    use BaseApp;

    public function create(Request $request)
    {
        $error_code = 'QZCE200';
        $data = null;
        try {
            $serviceOpentdb = new OpentdbService();
            $quizTable = new Quiz();
            $name = $request->name ?: 'Name';
            $quiz = $quizTable->createQuiz($name);
            $quiz_id = $quiz->id;
            $getQuestions = $serviceOpentdb->getQuestions();

            if (isset($getQuestions['results']) && ($getQuestions['results']) > 0) {

                $results = $getQuestions['results'];
                $questions = [];
                foreach ($results as $value) {
                    $question['question'] = html_entity_decode($value['question']);
                    $question['correct_answer'] = $value['correct_answer'] === "True";
                    $questions[] = $question;
                }
            }

            $questionUtility = new QuestionUtility;
            $question_ids = $questionUtility->createQuestions($questions);

            $quizTable->addQuestionsToQuiz($quiz_id, $question_ids);
            $data['id'] = $quiz_id;
        } catch (Exception $e) {
            $error_code = "QZCE500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }

    public function getQuices()
    {
        $error_code = 'QNGQ200';
        $data = null;
        try {
            $quizTable = new Quiz;
            $quices = $quizTable->getQuices();

            if (count($quices) <= 0) {
                $error_code = 'QNGQ400';
            } else {
                $data = $quices;
            }
        } catch (Exception $e) {
            $error_code = "QNGQ500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }

    public function getQuicesByUser($user_id)
    {
        $error_code = 'QZGQBU200';
        $data = null;
        try {
            $quizTable = new Quiz;
            $quices = $quizTable->getQuicesByUser($user_id);

            if (count($quices) <= 0) {
                $error_code = 'QZGQBU400';
            } else {
                $data = $quices;
            }
        } catch (Exception $e) {
            $error_code = "QZGQBU500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }

    public function deleteUserQuiz($quiz_id, $user_id)
    {
        $error_code = 'QZDUQ200';
        $data = null;
        try {
            $userQuizTable = new UserQuiz;
            $quices = $userQuizTable->deleteUserQuiz($quiz_id, $user_id);

            if ($quices) {
                $answerTable = new Answer;
                $deleteAnswers = $answerTable->deleteAnswersByQuiz($quiz_id, $user_id);

                if ($deleteAnswers) {
                    $data['id'] = $quiz_id;
                } else {
                    $error_code = 'QZDUQ402';
                }
            } else {
                $error_code = 'QZDUQ400';
            }
        } catch (Exception $e) {
            $error_code = "QZDUQ500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }

    public function existsQuizForUser($quiz_id, $user_id)
    {
        $error_code = 'QZEQFU200';
        $data = null;
        try {
            $userQuizTable = new UserQuiz;
            $quiz = $userQuizTable->getQuizByUser($quiz_id, $user_id);
            if (count($quiz)>0) {
                $data['exists'] = true;
            } else {
                $data['exists'] = false;
            }
        } catch (Exception $e) {
            $error_code = "QZEQFU500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }
}
