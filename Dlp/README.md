# Data Loss Prevention for PHP

> Idiomatic PHP client for [Google DLP](https://cloud.google.com/dlp/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-dlp/v/stable)](https://packagist.org/packages/google/cloud-dlp) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-dlp.svg)](https://packagist.org/packages/google/cloud-dlp)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-dlp/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

The DLP API lets you understand and manage sensitive data.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-dlp
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

use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\Cloud\Dlp\V2\ContentItem;
use Google\Cloud\Dlp\V2\InfoType;
use Google\Cloud\Dlp\V2\InspectConfig;

$dlpServiceClient = new DlpServiceClient();
$infoTypesElement = (new InfoType())
    ->setName('EMAIL_ADDRESS');
$inspectConfig = (new InspectConfig())
    ->setInfoTypes([$infoTypesElement]);
$item = (new ContentItem())
    ->setValue('My email is example@example.com.');
$formattedParent = $dlpServiceClient
    ->projectName('[PROJECT_ID]');

$response = $dlpServiceClient->inspectContent($formattedParent, [
    'inspectConfig' => $inspectConfig,
    'item' => $item
]);

$findings = $response->getResult()
    ->getFindings();

foreach ($findings as $finding) {
    print $finding->getInfoType()
        ->getName() . PHP_EOL;
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/dlp/docs).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/dlp).
