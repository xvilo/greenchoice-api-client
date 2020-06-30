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

$clientToken = $client->authentication->requestToken(
    'MobileApp',
    'A6E60EBF73521F57',
    'xxxxx-xxx-xxx-xxxx-xxxxxxxxxx',
    new Password(),
    'you@example.com',
    'S0mes3c#password'
);

// Authenticate
$client->authenticate($clientToken['access_token']);

// Get contracts
$contracts = $client->customer->getContracts();
if (count($contracts) === 0) {
    die('No contracts found for this customer');
}

$contractId = $contracts[0]['Id'];
$customerId = $contracts[0]['Klantnummer'];
echo sprintf("Using contract[ID=%s] for customer[ID=%s]", $contractId, $customerId) . PHP_EOL;

// Get approved contract
$approvedContract = $client->contracts->getApproved($contractId);
echo sprintf("Contract[ID=%s] has %s approved contract(s)", $contractId, count($approvedContract)) . PHP_EOL;

// Get contract features
$contractFeatures = $client->features->getByContractId($contractId);
echo sprintf("Contract[ID=%s] has %s contract feature(s)", $contractId, count($contractFeatures)) . PHP_EOL;

// Get contract counters
$contractCounters = $client->readings->getCounters($contractId);
echo sprintf("For contract[ID=%s] there is %s registered meter(s)", $contractId, count($contractCounters)) . PHP_EOL;

// get contract readings
$contractReadings = $client->readings->getCounterData($contractId);
echo sprintf("Last known meter readings since: \n\n  - %s:\n    - high: %s\n    - low: %s", $contractReadings[0]['DatumInvoer'], $contractReadings[0]['MeterstandenOutput'][0]['Hoog'], $contractReadings[0]['MeterstandenOutput'][0]['Laag']) . PHP_EOL;
```

Will output:

```txt
Using contract[ID=1234567] for customer[ID=67890]
Contract[ID=1234567] has 0 approved contract(s)
Contract[ID=1234567] has 4 contract feature(s)
For contract[ID=1234567] there is 1 registered meter(s)
Last known meter readings since: 

  - 2020-06-15T00:00:00:
    - high: 123456
    - low: 1234
```
