# Google Cloud Web Risk for PHP

> Idiomatic PHP client for [Google Cloud Web Risk](https://cloud.google.com/web-risk).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-web-risk/v/stable)](https://packagist.org/packages/google/cloud-web-risk) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-web-risk.svg)](https://packagist.org/packages/google/cloud-web-risk)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-web-risk/latest/webrisk/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

**NOTE:** Cloud Web Risk is not yet publicly available. You must be whitelisted in order to gain access. See [Setting up the Web Risk API](https://cloud.google.com/web-risk/docs/quickstart) in the product documentation for a link to the sign-up form.

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

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\Cloud\WebRisk\V1beta1\ThreatType;
use Google\Cloud\WebRisk\V1beta1\WebRiskServiceV1Beta1Client;

$webrisk = new WebRiskServiceV1Beta1Client();

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

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/web-risk/docs).
