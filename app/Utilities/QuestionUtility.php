<?php

namespace App\Utilities;

use App\Models\Question;
use App\Traits\BaseApp;

class QuestionUtility
{

    use BaseApp;

    public function createQuestions($questions)
    {

        $questionTable = new Question;
        $ids = [];
        foreach ($questions as $question) {
            $createQuestion = $questionTable->createQuestion($question);
            $ids[] = $createQuestion->id;
        }
        return $ids;
    }
}
