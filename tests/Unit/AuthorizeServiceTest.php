<?php

use App\Exceptions\ExternalServiceException;
use App\Services\AuthorizeService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

test('returns true when the service authorizes the transaction', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response([
            'status' => 'success',
            'data' => [
                'authorization' => true,
            ],
        ], 200),
    ]);

    $service = new AuthorizeService;
    expect($service->authorize())->toBeTrue();
});

test('returns false when the service responds with authorization false', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response([
            'status' => 'success',
            'data' => [
                'authorization' => false,
            ],
        ], 200),
    ]);

    $service = new AuthorizeService;
    expect($service->authorize())->toBeFalse();
});

test('returns false when the service responds with a non-success status', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response([
            'status' => 'fail',
            'data' => [],
        ], 200),
    ]);

    $service = new AuthorizeService;
    expect($service->authorize())->toBeFalse();
});

test('throws ExternalServiceException when http request fails', function () {
    Http::fake([
        'https://util.devi.tools/api/v2/authorize' => Http::response(null, 500),
    ]);

    $service = new AuthorizeService;
    $service->authorize();
})->throws(ExternalServiceException::class);

test('throws ExternalServiceException on connection failure', function () {
    Http::fake(fn () => throw new ConnectionException);

    $service = new AuthorizeService;
    $service->authorize();
})->throws(ExternalServiceException::class);
