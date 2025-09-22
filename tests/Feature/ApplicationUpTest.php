<?php

declare(strict_types=1);

use Exa\Support\Formatter;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

it('test that application is up', function (): void {
    expect($this->get('/')->json())
        ->toBe([
            'application' => config('app.name'),
            'status' => Response::HTTP_OK,
            'datetime' => Carbon::now()->format(Formatter::API_DATETIME_FORMAT),
            'environment' => config('app.env'),
            'php_version' => phpversion(),
            'laravel_version' => App::version(),
        ]);
});
