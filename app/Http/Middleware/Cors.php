<?php

namespace App\Http\Middleware;

use App\Helpers\UtilsHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

            $allowHeader = 'Accept, Content-Type, Access-Control-Allow-Headers, Access-Control-Request-Method, ';
            $allowHeader .= 'Authorization, X-Requested-With, company-id, allotment-id';

            $response->header('Access-Control-Allow-Headers', $allowHeader);
            $response->header('Access-Control-Max-Age', '3600');
            $response->header('Access-Control-Allow-Origin', "*");
        }
        if ($request->isMethod('OPTIONS')) {
            $response->setStatusCode(Response::HTTP_OK);
            $statusText = UtilsHelper::getValue(Response::HTTP_OK, Response::$statusTexts);
            $response->setContent($statusText);
        }
        return $response;
    }
}
