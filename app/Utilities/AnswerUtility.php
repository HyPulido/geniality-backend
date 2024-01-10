<?php

namespace App\Utilities;

use App\Models\Answer;
use App\Traits\BaseApp;

class AnswerUtility
{

    use BaseApp;

    public function createAnswers($answers, $user_id)
    {
        $answerTable = new Answer;
        $ids = [];
        foreach ($answers as $answer) {
            $answer['users_id'] = $user_id;
            $createAnswer = $answerTable->createAnswer($answer);
            $ids[] = $createAnswer->id;
        }
        return $ids;
    }
}
