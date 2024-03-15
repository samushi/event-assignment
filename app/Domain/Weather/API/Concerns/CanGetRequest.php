<?php

declare(strict_types=1);

namespace App\Domain\Weather\API\Concerns;

use Illuminate\Http\Client\Response;

trait CanGetRequest
{
    /**
     * Get Request from API
     */
    public function get(string $url, ?array $data = null): Response
    {
        return $this->buildRequestWithToken()->get(
            url: $url,
            query: $data
        );
    }
}
