# Google Cloud Workflows for PHP

> Idiomatic PHP client for [Google Cloud Workflows](https://cloud.google.com/workflows).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-workflows/v/stable)](https://packagist.org/packages/google/cloud-workflows) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-workflows.svg)](https://packagist.org/packages/google/cloud-workflows)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-workflows/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-workflows
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

use Google\Cloud\Workflows\V1beta\WorkflowsClient;

$client = new WorkflowsClient();

$workflows = $client->listWorkflows(
    WorkflowsClient::locationName('[MY_PROJECT_ID]', 'us-central1')
);

foreach ($workflows as $workflow) {
    print 'Found workflow: ' . $workflow->getName() . PHP_EOL;
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/workflows/docs).
