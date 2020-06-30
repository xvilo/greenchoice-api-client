<?php
declare(strict_types=1);

namespace Greenchoice;

use Greenchoice\Api\Features;
use Greenchoice\HttpClient\Builder;
use Greenchoice\HttpClient\Plugin\Authentication;
use Greenchoice\HttpClient\Plugin\Authentication\GrantType;
use Greenchoice\HttpClient\Plugin\History;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class Client
 * @author Sem Schilder <me@sem.design>
 */
class Client
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var Builder
     */
    private $httpClientBuilder;

    /**
     * @var History
     */
    private $responseHistory;

    public Api\Authentication $authentication;

    public Api\Customer $customer;

    public Api\Contracts $contracts;

    /**
     * @var Features
     */
    public Features $features;

    /**
     * @var Api\Readings
     */
    public Api\Readings $readings;

    /**
     * @var Api\Windvanger
     */
    public Api\Windvanger $windvanger;

    /**
     * @var Api\Usages
     */
    public Api\Usages $usages;

    /**
     * @param Builder|null $httpClientBuilder
     */
    public function __construct(Builder $httpClientBuilder = null)
    {
        // Setup Http client
        $this->responseHistory = new History();
        $this->httpClientBuilder = $httpClientBuilder ?: new Builder();

        $this->authentication = new Api\Authentication($this);
        $this->customer = new Api\Customer($this);
        $this->contracts = new Api\Contracts($this);
        $this->features = new Features($this);
        $this->readings = new Api\Readings($this);
        $this->windvanger = new Api\Windvanger($this);
        $this->usages = new Api\Usages($this);

        $this->setupHttpBuilder();
    }

    private function setupHttpBuilder(): void
    {
        $this->httpClientBuilder->addPlugin(new Plugin\HistoryPlugin($this->responseHistory));
        $this->httpClientBuilder->addPlugin(new Plugin\RedirectPlugin());
        $this->httpClientBuilder->addPlugin(new Plugin\AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://app.greenchoice.nl')));
    }

    /**
     * Create a Greenchoice\Client using a HttpClient.
     *
     * @param HttpClient $httpClient
     *
     * @return Client
     */
    public static function createWithHttpClient(HttpClient $httpClient)
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string $accessToken
     * @param string $accessTokenSso
     */
    public function authenticate(
        string $accessToken,
        string $accessTokenSso
    ) {
        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($accessToken, $accessTokenSso));
    }

    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param CacheItemPoolInterface $cachePool
     * @param array                  $config
     */
    public function addCache(CacheItemPoolInterface $cachePool, array $config = [])
    {
        $this->getHttpClientBuilder()->addCache($cachePool, $config);
    }

    /**
     * Remove the cache plugin.
     */
    public function removeCache()
    {
        $this->getHttpClientBuilder()->removeCache();
    }

    /**
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->responseHistory->getLastResponse();
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder()
    {
        return $this->httpClientBuilder;
    }
}
