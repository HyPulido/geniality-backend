<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get("/list", withAttemptsMiddleware("QuestionnaireController@getList", 1));

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->post("/quiz/create", withAttemptsMiddleware("QuizController@create", 5));
    $router->get("/quiz/{quiz_id}/questions", withAttemptsMiddleware("QuestionController@getQuestionsByQuiz", 10));
    $router->get("/quices", withAttemptsMiddleware("QuizController@getQuices", 20));
    $router->post("/answers", withAttemptsMiddleware("AnswerController@processAnswers", 10));
    $router->put("/answers", withAttemptsMiddleware("AnswerController@processUpdateAnswers", 10));
    $router->get("/quiz/{quiz_id}/answers", withAttemptsMiddleware("AnswerController@getAnswersByQuiz", 10));
    $router->post("/user", withAttemptsMiddleware("UserController@create", 5));
    $router->get("/quices/user/{user_id}", withAttemptsMiddleware("QuizController@getQuicesByUser", 10));
    $router->delete("/quiz/{quiz_id}/user/{user_id}", withAttemptsMiddleware("QuizController@deleteUserQuiz", 10));
    $router->get("/quiz/{quiz_id}/user/{user_id}", withAttemptsMiddleware("QuizController@existsQuizForUser", 10));
});

function withAttemptsMiddleware($controller, $maxAttempts)
{
    return ['middleware' => 'throttle:' . $maxAttempts, 'uses' => $controller];
}
