# Google Cloud Intrusion Detection Service for PHP

> Idiomatic PHP client for [Google Cloud IDS](https://cloud.google.com/intrusion-detection-system/docs/overview).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-ids/v/stable)](https://packagist.org/packages/google/cloud-ids)
[![Packagist](https://img.shields.io/packagist/dm/google/cloud-ids.svg)](https://packagist.org/packages/google/cloud-ids)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-ids/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Cloud IDS is an intrusion detection service that provides threat detection for intrusions, malware, spyware, and command-and-control attacks on your network.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-ids
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Ids\V1\IDSClient;

$idsClient = new IDSClient();
$formattedParent = $iDSClient->locationName('[PROJECT]', '[LOCATION]');
$endpointId = 'endpoint_id';
$endpoint = new Endpoint();
$operationResponse = $iDSClient->createEndpoint($formattedParent, $endpointId, $endpoint);
$operationResponse->pollUntilComplete();
if ($operationResponse->operationSucceeded()) {
    $result = $operationResponse->getResult();
    // doSomethingWith($result)
} else {
    $error = $operationResponse->getError();
    // handleError($error)
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/intrusion-detection-system/docs/overview).
