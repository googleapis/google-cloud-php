# Google Cloud Dataproc for PHP

> Idiomatic PHP client for [Google Cloud Dataproc](https://cloud.google.com/dataproc/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-dataproc/v/stable)](https://packagist.org/packages/google/cloud-dataproc) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-dataproc.svg)](https://packagist.org/packages/google/cloud-dataproc)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-dataproc/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A managed Apache Spark and Apache Hadoop service that lets you take advantage of open source data tools for batch
processing, querying, streaming, and machine learning. Cloud Dataproc automation helps you create clusters quickly,
manage them easily, and save money by turning clusters off when you don't need them. With less time and money spent on
administration, you can focus on your jobs and your data.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-dataproc
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

use Google\Cloud\Dataproc\V1\JobControllerClient;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\HadoopJob;
use Google\Cloud\Dataproc\V1\JobPlacement;

$projectId = '[MY_PROJECT_ID]';
$region = 'global';
$clusterName = '[MY_CLUSTER]';

$jobPlacement = new JobPlacement();
$jobPlacement->setClusterName($clusterName);

$hadoopJob = new HadoopJob();
$hadoopJob->setMainJarFileUri('gs://my-bucket/my-hadoop-job.jar');

$job = new Job();
$job->setPlacement($jobPlacement);
$job->setHadoopJob($hadoopJob);

$jobControllerClient = new JobControllerClient();
$submittedJob = $jobControllerClient->submitJob($projectId, $region, $job);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/dataproc/docs).
