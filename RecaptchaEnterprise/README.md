# Google Cloud Recaptcha Enterprise for PHP

> Idiomatic PHP client for [Google Cloud Recaptcha Enterprise](https://cloud.google.com/recaptcha-enterprise).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-recaptcha-enterprise/v/stable)](https://packagist.org/packages/google/cloud-recaptcha-enterprise) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-recaptcha-enterprise.svg)](https://packagist.org/packages/google/cloud-recaptcha-enterprise)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-recaptcha-enterprise/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-recaptcha-enterprise
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\FirewallPolicy;
use Google\Cloud\RecaptchaEnterprise\V1\GetFirewallPolicyRequest;

// Create a client.
$recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

// Prepare the request message.
$request = (new GetFirewallPolicyRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var FirewallPolicy $response */
    $response = $recaptchaEnterpriseServiceClient->getFirewallPolicy($request);
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

1. Understand the [official documentation](https://cloud.google.com/recaptcha-enterprise/docs).
