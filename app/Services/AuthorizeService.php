<?php

namespace App\Services;

use App\Exceptions\ExternalServiceException;
use App\Services\Interfaces\AuthorizeServiceInterface;
use Http;
use Illuminate\Http\Client\ConnectionException;

class AuthorizeService implements AuthorizeServiceInterface
{
    /**
     * O endpoint externo do serviço de autorização.
     */
    protected const string AUTHORIZE_URL = 'https://util.devi.tools/api/v2/authorize';

    /**
     * Tempo de espera para a resposta do serviço externo.
     */
    protected const int TIMEOUT = 5;

    /**
     * Número de tentativas de nova autorização em caso de falha.
     */
    protected const int RETRY_ATTEMPTS = 2;

    /**
     * Tempo de espera entre as tentativas de nova autorização em milissegundos.
     */
    protected const int RETRY_DELAY = 100;

    public function authorize(): bool
    {
        try {
            $response = Http::timeout(self::TIMEOUT)
                ->retry(self::RETRY_ATTEMPTS, self::RETRY_DELAY)
                ->get(self::AUTHORIZE_URL);

            return $response->successful() && $this->isAuthorized($response->json());

        } catch (ConnectionException $e) {
            throw new ExternalServiceException('Failed to connect to the external authorization service.', 0, $e);
        } catch (\Exception $e) {
            throw new ExternalServiceException('An error occurred while checking authorization.', 0, $e);
        }
    }

    protected function isAuthorized(?array $response): bool
    {
        return isset($response['status']) &&
            $response['status'] === 'success' &&
            isset($response['data']['authorization']) &&
            $response['data']['authorization'] === true;
    }
}
