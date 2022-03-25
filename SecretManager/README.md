# Secret Manager for PHP

> Idiomatic PHP client for [Secret Manager](https://cloud.google.com/secret-manager).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-secret-manager/v/stable)](https://packagist.org/packages/google/cloud-secret-manager) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-secret-manager.svg)](https://packagist.org/packages/google/cloud-secret-manager)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-secret-manager/latest/secretmanager/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-secret-manager
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
require 'vendor/autoload.php';

use Google\Cloud\SecretManager\V1\Replication;
use Google\Cloud\SecretManager\V1\Replication\Automatic;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

$client = new SecretManagerServiceClient();

$secret = $client->createSecret(
    SecretManagerServiceClient::projectName('[MY_PROJECT_ID]'),
    '[MY_SECRET_ID]',
    new Secret([
        'replication' => new Replication([
            'automatic' => new Automatic()
        ])
    ])
);

printf(
    'Created secret: %s' . PHP_EOL,
    $secret->getName()
);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/secret-manager/docs).
