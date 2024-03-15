<?php

declare(strict_types=1);

namespace App\Domain\Weather\API\Concerns;

use App\Domain\Weather\API\Guzzle\ProxyValidationErrors;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

trait BuildBaseRequest
{
    /**
     * Build request with token
     * @return PendingRequest
     */
    public function buildRequestWithToken(): PendingRequest
    {
        return $this->withBaseUrl()
            ->withOptions(['query' => ['key' => $this->apiToken]])
            ->timeout(
                seconds: 15,
            )->withMiddleware(
                new ProxyValidationErrors()
            )->withMiddleware(
                $this->getCacheMiddleware()
            );
    }

    /**
     * Initialize base url
     * @return PendingRequest
     */
    public function withBaseUrl(): PendingRequest
    {
        return Http::baseUrl(
            url: $this->baseUrl,
        );
    }

    /**
     * Get cache middleware
     * @return CacheMiddleware
     */
    protected function getCacheMiddleware(): CacheMiddleware
    {
        return new CacheMiddleware(
            new PrivateCacheStrategy(new LaravelCacheStorage(cache()->store()))
        );
    }
}
