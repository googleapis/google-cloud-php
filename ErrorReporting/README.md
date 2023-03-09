# Stackdriver Error Reporting for PHP

> Idiomatic PHP client for [Stackdriver Error Reporting](https://cloud.google.com/error-reporting/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-error-reporting/v/stable)](https://packagist.org/packages/google/cloud-error-reporting) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-error-reporting.svg)](https://packagist.org/packages/google/cloud-error-reporting)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-error-reporting/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Stackdriver Error Reporting counts, analyzes and aggregates the crashes in your running cloud services.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-error-reporting
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

The Stackdriver Error Reporting client provides APIs allowing you to easily configure your application to send errors and exceptions automatically to Stackdriver, or to manually report and manage errors and statistics.

#### Reporting errors from your application:

```php
require 'vendor/autoload.php';

use Google\Cloud\ErrorReporting\Bootstrap;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Core\Report\SimpleMetadataProvider;

$projectId = '[PROJECT]';
$service = '[SERVICE_NAME]';
$version = '[APP_VERSION]';

$logging = new LoggingClient();
$metadata = new SimpleMetadataProvider([], $projectId, $service, $version);
$psrLogger = $logging->psrLogger('error-log', [
    'metadataProvider' => $metadata
]);

// Register the logger as a PHP exception and error handler.
// This will begin logging application exceptions and errors to Stackdriver.
Bootstrap::init($psrLogger);
```

#### Using the Error Reporting API:

```php
require 'vendor/autoload.php';

use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ReportedErrorEvent;

$reportErrorsServiceClient = new ReportErrorsServiceClient();
$formattedProjectName = $reportErrorsServiceClient->projectName('[PROJECT]');
$event = new ReportedErrorEvent();

try {
    $response = $reportErrorsServiceClient->reportErrorEvent($formattedProjectName, $event);
} finally {
    $reportErrorsServiceClient->close();
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/error-reporting/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/error_reporting).
