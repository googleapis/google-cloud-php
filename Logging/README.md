# Stackdriver Logging for PHP

> Idiomatic PHP client for [Stackdriver Logging](https://cloud.google.com/logging/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-logging/v/stable)](https://packagist.org/packages/google/cloud-logging) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-logging.svg)](https://packagist.org/packages/google/cloud-logging)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-logging/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows you to store, search, analyze, monitor, and alert on log data and events from Google Cloud Platform and Amazon
Web Services.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-logging
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

use Google\Cloud\Logging\LoggingClient;

$logging = new LoggingClient();

// Get a logger instance.
$logger = $logging->logger('my_log');

// Write a log entry.
$logger->write('my message');

// List log entries from a specific log.
$entries = $logging->entries([
    'filter' => 'logName = projects/my_project/logs/my_log'
]);

foreach ($entries as $entry) {
    echo $entry->info()['textPayload'] . "\n";
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/logging/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/logging/).
