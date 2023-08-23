# Cloud Scheduler for PHP

> Idiomatic PHP client for [Cloud Scheduler](https://cloud.google.com/scheduler).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-scheduler/v/stable)](https://packagist.org/packages/google/cloud-scheduler) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-scheduler.svg)](https://packagist.org/packages/google/cloud-scheduler)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-scheduler/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-scheduler
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

use Google\Cloud\Scheduler\V1\AppEngineHttpTarget;
use Google\Cloud\Scheduler\V1\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1\Job;
use Google\Cloud\Scheduler\V1\Job\State;

$client = new CloudSchedulerClient();
$projectId = '[MY_PROJECT_ID]';
$location = 'us-central1';
$parent = CloudSchedulerClient::locationName($projectId, $location);
$job = new Job([
    'name' => CloudSchedulerClient::jobName(
        $projectId,
        $location,
        uniqid()
    ),
    'app_engine_http_target' => new AppEngineHttpTarget([
        'relative_uri' => '/'
    ]),
    'schedule' => '* * * * *'
]);
$client->createJob($parent, $job);

foreach ($client->listJobs($parent) as $job) {
    printf(
        'Job: %s : %s' . PHP_EOL,
        $job->getName(),
        State::name($job->getState())
    );
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/scheduler/docs).
