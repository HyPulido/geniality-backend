<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    protected $table = "answers";

    protected $fillable = ['id', 'answer', 'questions_id', 'users_id', 'created_at', 'updated_at'];

    // public $timestamps = false;

    public function createAnswer($answer)
    {
        return self::updateOrCreate(
            ['users_id' => $answer['users_id'], 'questions_id' => $answer['questions_id']],
            $answer,
        );
    }

    public function getAnswersByQuiz($quiz_id)
    {
        return $this->select('answers.id', 'answers.answer', 'questions.id AS question_id', 'questions.question', 'questions.correct_answer', 'quices.id AS quiz_id', 'users.id AS user_id', DB::raw('IF(answers.answer = questions.correct_answer, 1, 0) AS points'))
            ->join('users', 'users_id', 'users.id')
            ->join('questions', 'questions_id', 'questions.id')
            ->join('quices_questions', 'questions.id', 'quices_questions.questions_id')
            ->join('quices', 'quices_questions.quices_id', 'quices.id')
            ->where('quices.id', $quiz_id)
            ->get();
    }



    public function deleteAnswersByQuiz($quiz_id, $user_id)
    {
        return $this
            ->join('questions', 'questions_id', 'questions.id')
            ->join('quices_questions', 'questions.id', 'quices_questions.questions_id')
            ->join('quices', 'quices_questions.quices_id', 'quices.id')
            ->where('quices.id', $quiz_id)
            ->where('users_id', $user_id)
            ->delete();
    }
}
