# Cloud KMS V1 generated client for PHP

### Sample

```php
require __DIR__ . '/vendor/autoload.php';

use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\CryptoKey\CryptoKeyPurpose;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\KeyRing;

$client = new KeyManagementServiceClient();

$projectId = 'example-project';
$location = 'global';

// Create a keyring
$keyRingId = 'example-keyring';
$locationName = $client::locationName($projectId, $location);
$keyRingName = $client::keyRingName($projectId, $location, $keyRingId);

try {
    $keyRing = $client->getKeyRing($keyRingName);
} catch (ApiException $e) {
    if ($e->getStatus() === 'NOT_FOUND') {
        $keyRing = new KeyRing();
        $keyRing->setName($keyRingName);
        $client->createKeyRing($locationName, $keyRingId, $keyRing);
    }
}

// Create a cryptokey
$keyId = 'example-key';
$keyName = $client::cryptoKeyName($projectId, $location, $keyRingId, $keyId);

try {
    $cryptoKey = $client->getCryptoKey($keyName);
} catch (ApiException $e) {
    if ($e->getStatus() === 'NOT_FOUND') {
        $cryptoKey = new CryptoKey();
        $cryptoKey->setPurpose(CryptoKeyPurpose::ENCRYPT_DECRYPT);
        $cryptoKey = $client->createCryptoKey($keyRingName, $keyId, $cryptoKey);
    }
}

// Encrypt and decrypt
$secret = 'My secret text';
$response = $client->encrypt($keyName, $secret);
$cipherText = $response->getCiphertext();

$response = $client->decrypt($keyName, $cipherText);

$plainText = $response->getPlaintext();

assert($secret === $plainText);
```
