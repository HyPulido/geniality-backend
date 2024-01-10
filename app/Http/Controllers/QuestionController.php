<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Traits\BaseApp;
use Exception;

class QuestionController extends Controller
{
    use BaseApp;

    public function getQuestionsByQuiz($quiz_id)
    {
        $error_code = 'QNGQBQ200';
        $data = null;
        try {
            $questionTable = new Question;
            $questions = $questionTable->getQuestionsByQuiz($quiz_id);
            if (count($questions) <= 0) {
                $error_code = 'QNGQBQ400';
            } else {
                $data = $questions;
            }
        } catch (Exception $e) {
            $error_code = "QNGQBQ500";
            $data[] = $this->getException($e);
        }

        return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => $data, 'function' => __FUNCTION__, 'class' => __CLASS__));
    }
}
