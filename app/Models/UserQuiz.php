<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    protected $table = "users_quices";

    protected $fillable = ['id', 'users_id', 'quices_id', 'created_at', 'updated_at'];

    // public $timestamps = false;

    public function addQuizToUser($quiz_id, $user_id)
    {
        $this::updateOrCreate(
            ['users_id' => $user_id, 'quices_id' => $quiz_id],
            ['users_id' => $user_id, 'quices_id' => $quiz_id],
        );

        return $this;
    }


    public function deleteUserQuiz($quiz_id, $user_id)
    {
        return $this->where('users_id', $user_id)->where('quices_id', $quiz_id)->delete();
    }

    public function getQuizByUser($quiz_id, $user_id)
    {
        return $this->where('users_id', $user_id)->where('quices_id', $quiz_id)->get();
    }
}
