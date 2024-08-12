<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantesProvider extends ServiceProvider {
    
    public const OK = 200;
    public const CREATED = 201;
    public const NO_CONTENT = 204;
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const UNPROCESSABLE = 422;
    public const SERVER_ERROR = 500;



}