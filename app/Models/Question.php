<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";

    protected $fillable = ['id', 'question', 'correct_answer', 'created_at', 'updated_at'];

    // public $timestamps = false;


    public function quices()
    {
        return $this->belongsToMany(Quiz::class, 'quices_questions', 'questions_id', 'quices_id');
    }

    public function createQuestion($question)
    {
        return self::create($question);
    }

    public function getQuestionsByQuiz($quiz_id)
    {
        return $this->select('questions.id', 'questions.question',  'questions.created_at', 'questions.updated_at')
            ->join('quices_questions', 'questions.id', '=', 'quices_questions.questions_id')
            ->join('quices', 'quices_questions.quices_id', '=', 'quices.id')
            ->where('quices.id', '=', $quiz_id)
            ->orderBy('created_at', 'ASC')->get();
    }
}