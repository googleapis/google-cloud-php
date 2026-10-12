# Stackdriver Monitoring

[![Latest Stable Version](https://poser.pugx.org/google/cloud-monitoring/v/stable)](https://packagist.org/packages/google/cloud-monitoring) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-monitoring.svg)](https://packagist.org/packages/google/cloud-monitoring)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-monitoring/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Stackdriver Monitoring provides visibility into the performance, uptime, and overall health of cloud-powered applications.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-monitoring
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\Client\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\GetAlertPolicyRequest;

// Create a client.
$alertPolicyServiceClient = new AlertPolicyServiceClient();

// Prepare the request message.
$request = (new GetAlertPolicyRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var AlertPolicy $response */
    $response = $alertPolicyServiceClient->getAlertPolicy($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/monitoring/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/monitoring/).
