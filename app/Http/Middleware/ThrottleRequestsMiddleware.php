<?php

namespace App\Http\Middleware;

use App\Traits\BaseApp;
use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ThrottleRequestsMiddleware extends ThrottleRequests
{

    use BaseApp;

    protected function resolveRequestSignature($request)
    {
        return $request->fingerprint();
    }

    protected function handleRequest($request, Closure $next, array $limits)
    {

        foreach ($limits as $limit) {
            if ($this->limiter->tooManyAttempts($limit->key, $limit->maxAttempts)) {
                $error_code = 'TRHR429';
                return $this->setCustomizeResponse(array('error_code' => $error_code, 'data' => null, 'function' => __FUNCTION__, 'class' => __CLASS__, "message"=>"too many request, max is {time}"), array('time' => $limit->maxAttempts));
            }

            $this->limiter->hit($limit->key, $limit->decayMinutes * 60);
        }

        $response = $next($request);

        foreach ($limits as $limit) {
            $response = $this->addHeaders(
                $response,
                $limit->maxAttempts,
                $this->calculateRemainingAttempts($limit->key, $limit->maxAttempts)
            );
        }

        return $response;
    }
}
