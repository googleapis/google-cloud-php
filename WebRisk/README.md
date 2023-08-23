# Google Cloud Web Risk for PHP

> Idiomatic PHP client for [Google Cloud Web Risk](https://cloud.google.com/web-risk).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-web-risk/v/stable)](https://packagist.org/packages/google/cloud-web-risk) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-web-risk.svg)](https://packagist.org/packages/google/cloud-web-risk)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-web-risk/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

Install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-web-risk
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
use Google\Cloud\WebRisk\V1\ThreatType;
use Google\Cloud\WebRisk\V1\WebRiskServiceClient;

$webrisk = new WebRiskServiceClient();

$uri = 'http://testsafebrowsing.appspot.com/s/malware.html';
$response = $webrisk->searchUris($uri, [
    ThreatType::MALWARE,
    ThreatType::SOCIAL_ENGINEERING
]);

$threats = $response->getThreat();
if ($threats) {
    echo $uri . ' has the following threats:' . PHP_EOL;
    foreach ($threats->getThreatTypes() as $threat) {
        echo ThreatType::name($threat) . PHP_EOL;
    }
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/web-risk/docs).
