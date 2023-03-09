# Google Cloud IoT Core for PHP

> Idiomatic PHP client for [Google Cloud IoT Core](https://cloud.google.com/iot-core/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-iot/v/stable)](https://packagist.org/packages/google/cloud-iot) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-iot.svg)](https://packagist.org/packages/google/cloud-iot)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-iot/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A fully managed service for securely connecting and managing IoT devices, from a few to millions. Ingest data from
connected devices and build rich applications that integrate with the other big data services of Google Cloud Platform.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-iot
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Iot\V1\DeviceManagerClient;

$deviceManager = new DeviceManagerClient();

$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$registryId = '[MY_REGISTRY_ID]';
$registryName = $deviceManager->registryName($projectId, $location, $registryId);
$devices = $deviceManager->listDevices($registryName);
foreach ($devices->iterateAllElements() as $device) {
    printf('Device: %s : %s' . PHP_EOL,
        $device->getNumId(),
        $device->getId()
    );
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/iot/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/iot).
