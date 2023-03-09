# Google Cloud BigQuery Data Transfer for PHP

> Idiomatic PHP client for [Google Cloud BigQuery Data Transfer](https://cloud.google.com/bigquery/transfer/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-bigquerydatatransfer/v/stable)](https://packagist.org/packages/google/cloud-bigquerydatatransfer) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-bigquerydatatransfer.svg)](https://packagist.org/packages/google/cloud-bigquerydatatransfer)

* [API Documentation](https://cloud.google.com/php/docs/reference/cloud-bigquerydatatransfer/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Transfers data from partner SaaS applications to Google BigQuery on a scheduled, managed basis.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-bigquerydatatransfer
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

use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;

$dataTransferServiceClient = new DataTransferServiceClient();
$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$formattedLocation = $dataTransferServiceClient->locationName($projectId, $location);
$dataSources = $dataTransferServiceClient->listDataSources($formattedLocation);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/bigquery/docs/transfer-service-overview).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigquerydatatransfer).
