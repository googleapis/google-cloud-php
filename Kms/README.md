# Cloud KMS for PHP

> Idiomatic PHP client for [Cloud KMS](https://cloud.google.com/kms/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-kms/v/stable)](https://packagist.org/packages/google/cloud-kms) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-kms.svg)](https://packagist.org/packages/google/cloud-kms)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-kms/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-kms
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

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

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/kms/docs).
