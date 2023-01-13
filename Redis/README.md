# Google Cloud Redis for PHP

> Idiomatic PHP client for [Google Cloud Redis](https://cloud.google.com/memorystore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-redis/v/stable)](https://packagist.org/packages/google/cloud-redis) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-redis.svg)](https://packagist.org/packages/google/cloud-redis)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-redis/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully managed Redis service for the Google Cloud Platform. Applications running on Google Cloud Platform can achieve
extreme performance by leveraging the highly scalable, available, secure Redis service without the burden of managing complex Redis deployments.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-redis
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Redis\V1\CloudRedisClient;

$client = new CloudRedisClient();

$projectId = '[MY_PROJECT_ID]';
$location = '-'; // The '-' wildcard refers to all regions available to the project for the listInstances method
$formattedLocationName = $client->locationName($projectId, $location);
$response = $client->listInstances($formattedLocationName);
foreach ($response->iterateAllElements() as $instance) {
    printf('Instance: %s : %s' . PHP_EOL,
        $instance->getDisplayName(),
        $instance->getName()
    );
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/memorystore/docs/).
