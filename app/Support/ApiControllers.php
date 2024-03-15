<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\Exceptions\ValidationException;
use App\Support\Traits\HttpResponseTrait;
use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Throwable;

abstract class ApiControllers extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, HttpResponseTrait, ValidatesRequests;

    /**
     * Validation throw exception
     */
    protected function throwValidationException(): Closure
    {
        return fn (Throwable $throwable) => $throwable instanceof ValidationException ?
            $this->unAuthorized($throwable->getMessage()) :
            $this->errorWithMessage($throwable->getMessage());
    }
}
