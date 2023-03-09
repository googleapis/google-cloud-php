# Google Cloud Web Security Scanner for PHP

> Idiomatic PHP client for [Google Cloud Web Security Scanner](https://cloud.google.com/security-scanner).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-web-security-scanner/v/stable)](https://packagist.org/packages/google/cloud-web-security-scanner) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-web-security-scanner.svg)](https://packagist.org/packages/google/cloud-web-security-scanner)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-web-security-scanner/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-web-security-scanner
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

use Google\Cloud\WebSecurityScanner\V1beta\ScanConfig;
use Google\Cloud\WebSecurityScanner\V1beta\ScanConfig\UserAgent;
use Google\Cloud\WebSecurityScanner\V1beta\ScanRun\ExecutionState;
use Google\Cloud\WebSecurityScanner\V1beta\WebSecurityScannerClient;

$client = new WebSecurityScannerClient();
$scanConfig = $client->createScanConfig(
    WebSecurityScannerClient::projectName('[MY_PROJECT_ID'),
    new ScanConfig([
        'display_name' => 'Test Scan',
        'starting_urls' => ['https://[MY_APPLICATION_ID].appspot.com/'],
        'user_agent' => UserAgent::CHROME_LINUX
    ])
);
$scanRun = $client->startScanRun($scanConfig->getName());

echo 'Scan execution state: ' . ExecutionState::name($scanRun->getExecutionState()) . PHP_EOL;
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/security-scanner/docs).
