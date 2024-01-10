<?php

namespace App\Services;

use App\Services\LogsServices;
use App\Traits\BaseApp;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class OpentdbService
{

    use BaseApp;
    use LogsServices;

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getQuestions()
    {
        try {
            $start = Carbon::now();
            $url = getenv('OPENTDB_ENDPOINT') . "/api.php?amount=10&difficulty=hard&type=boolean";
            $api = "Get Questions";
            $request = new Request('GET', $url);
            $response = $this->client->send($request);
            $result = $this->processService($api, $request, $response, $start);
            return json_decode($result, true);
        } catch (Exception $e) {
            $data = $this->getException($e);
            Log::channel("error_provider")->alert(json_encode($data));
        }
    }
}
