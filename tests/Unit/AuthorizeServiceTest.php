<?php

use App\Exceptions\ExternalServiceException;
use App\Services\AuthorizeService;
use Illuminate\Support\Facades\Http;

test('Returns true when service responds with authorized message', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response(['message' => 'authorized'], 200),
    ]);

    $service = new AuthorizeService;
    expect($service->checkAuthorization())->toBeTrue();
});

test('Throws ExternalServiceException on connection failure', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response(null, 500),
    ]);

    $service = new AuthorizeService;
    expect(fn () => $service->checkAuthorization())->toThrow(ExternalServiceException::class);
});
