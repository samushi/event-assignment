<?php

declare(strict_types=1);

namespace App\Support\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

final readonly class ForceJsonResponse
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    /**
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // First set the header so any other middleware knows we're
        // dealing with a should-be JSON response
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        // If the response is not strictly a JsonResponse, we make it
        if ( ! $response instanceof JsonResponse) {
            $response = $this->responseFactory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;
    }
}
