# Google Cloud Asset for PHP

> Idiomatic PHP client for [Google Cloud Asset](https://cloud.google.com/resource-manager/docs/cai/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-asset/v/stable)](https://packagist.org/packages/google/cloud-asset) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-asset.svg)](https://packagist.org/packages/google/cloud-asset)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-asset/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-asset
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
require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\GcsDestination;
use Google\Cloud\Asset\V1\OutputConfig;

$objectPath = 'gs://your-bucket/cai-export';
// Now you need to change this with your project number (numeric id)
$project = 'example-project';

$client = new AssetServiceClient();

$gcsDestination = new GcsDestination(['uri' => $objectPath]);
$outputConfig = new OutputConfig(['gcs_destination' => $gcsDestination]);

$resp = $client->exportAssets("projects/$project", $outputConfig);

$resp->pollUntilComplete();

if ($resp->operationSucceeded()) {
    echo "The result is dumped to $objectPath successfully." . PHP_EOL;
} else {
    $error = $resp->getError();
    // handleError($error)
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/resource-manager/docs/cai/).
