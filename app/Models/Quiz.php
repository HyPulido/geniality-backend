<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = "quices";

    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];

    // public $timestamps = false;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quices_questions', 'quices_id', 'questions_id');
    }

    public function createQuiz($name)
    {
        $this->name = $name;
        $this->save();
        return $this;
    }


    public function addQuestionsToQuiz($quiz_id, $questions)
    {
        $group = $this::find($quiz_id);
        foreach ($questions as $value) {
            $group->questions()->attach($value);
        }
    }


    public function getQuices()
    {
        return $this->get();
    }

    public function getQuicesByUser($user_id)
    {
        return $this->select('quices.*')
            ->join('users_quices', 'quices.id', 'users_quices.quices_id')
            ->where('users_quices.users_id', $user_id)
            ->get();
    }
}
