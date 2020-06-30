# Greenchoice API Client (PHP)

A Greenchoice API Wrapper, please note that there is currently no official public API. However, this API client has been 
made by inspecting network traffic from their app. 

### Installation
You can install this package through composer, the easiest way is to:
```
composer require xvilo/greenchoice
```

### Usage
Somme usage examples:

```php
<?php
declare(strict_types=1);

use Greenchoice\HttpClient\Plugin\Authentication\GrantType\Password;

require_once 'vendor/autoload.php';

$client = new Greenchoice\Client();
$clientTokenSso = $client->authentication->requestTokenSso(
    'app-mobileapi',
    'xxxxx-xxx-xxx-xxxx-xxxxxxxxxx',
    'xxxxx-xxx-xxx-xxxx-xxxxxxxxxx',
    'openid offline_access',
    new Password(),
    'you@example.com',
    'S0mes3c#password'
);

$clientToken = $client->authentication->requestToken(
    'MobileApp',
    'A6E60EBF73521F57',
    'xxxxx-xxx-xxx-xxxx-xxxxxxxxxx',
    new Password(),
    'you@example.com',
    'S0mes3c#password'
);

$client->authenticate($clientToken['access_token'], $clientTokenSso['access_token']);

// Get contracts
$contracts = $client->customer->getContracts();

if (count($contracts) === 0) {
    die('No contracts found for this customer');
}

$contractId = $contracts[0]['Id'];

// Get approved contract
$approvedContract = $client->contracts->getApproved($contractId);

// Get contract features
$contractFeatures = $client->features->getByContractId($contractId);

// Get contract counters
$contractCounters = $client->readings->getCounters($contractId);

// get contract readings
$contractReadings = $client->readings->getCounterData($contractId);

// Windvanger generated data
$windvangerData = $client->windvanger->getGenerated($contractId, 'xxxxxx', new DateTime('2020-06-01'));

// Get usage periods
$usagePeriods = $client->usages->getUsagePeriods($contractId, new DateTime('2010-01-01'), new DateTime('2021-01-01'));
```
