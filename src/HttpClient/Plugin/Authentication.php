<?php

namespace Greenchoice\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

class Authentication implements Plugin
{
    use Plugin\VersionBridgePlugin;

    private string $accessToken;
    private ?string $accessTokenSso;

    public function __construct(
        string $accessToken,
        string $accessTokenSso = null
    ) {
        $this->accessToken = $accessToken;
        $this->accessTokenSso = $accessTokenSso;
    }

    /**
     * {@inheritdoc}
     */
    public function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        if ($this->accessTokenSso !== null) {
            $request = $request->withHeader('SSO-Authorization', sprintf('Bearer %s', $this->accessTokenSso));
        }

        $request = $request->withHeader('Authorization', sprintf('Bearer %s', $this->accessToken));

        return $next($request);
    }

}
