<?php

use Exa\Support\Formatter;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

it('test that application is up', function () {
    expect($this->get('/')->json())
        ->toBe([
            'application' => config('app.name'),
            'environment' => config('app.env'),
            'php_version' => phpversion(),
            'laravel_version' => App::version(),
            'status' => Response::HTTP_OK,
            'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
        ]);
});
