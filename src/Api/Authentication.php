<?php
declare(strict_types=1);

namespace Greenchoice\Api;

use Greenchoice\HttpClient\Plugin\Authentication\GrantType;
use function GuzzleHttp\Psr7\build_query;

class Authentication extends AbstractApi
{
    public function requestTokenSso(
        string $clientId,
        string $clientSecret,
        string $deviceId,
        string $scope,
        GrantType $grantType,
        string $username,
        string $password
    ): array {
        $query = build_query(['client_id' => $clientId,
            'client_secret' => $clientSecret,
            'device_id' => $deviceId,
            'grant_type' => $grantType->getKey(),
            'password' => $password,
            'username' => $username,
            'scope' => $scope
        ]);

        $spul = $this->client->getHttpClient()->post('https://sso.greenchoice.nl/connect/token', [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'Greenchoice/2.3.1 (iPhone; iOS 14.0; Scale/3.00)',
        ], $query);

        return json_decode((string)$spul->getBody(), true);
    }

    public function requestToken(
        string $clientId,
        string $clientSecret,
        string $deviceId,
        GrantType $grantType,
        string $username,
        string $password
    ): array {
        $query = build_query(['client_id' => $clientId,
            'client_secret' => $clientSecret,
            'device_id' => $deviceId,
            'grant_type' => $grantType->getKey(),
            'password' => $password,
            'username' => $username,
            'scope' => 'openid offline_access'
        ]);

        return $this->postRaw('token', $query);
    }
}
