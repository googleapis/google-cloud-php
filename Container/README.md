# Google Cloud Container for PHP

> Idiomatic PHP client for [Google Cloud Container](https://cloud.google.com/kubernetes-engine/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-container/v/stable)](https://packagist.org/packages/google/cloud-container) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-container.svg)](https://packagist.org/packages/google/cloud-container)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-container/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Kubernetes Engine is a managed, production-ready environment for deploying containerized applications. It brings our
latest innovations in developer productivity, resource efficiency, automated operations, and open source flexibility to
accelerate your time to market.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-container
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

use Google\Cloud\Container\V1\ClusterManagerClient;

$clusterManagerClient = new ClusterManagerClient();

$projectId = '[MY-PROJECT-ID]';
$zone = 'us-central1-a';

try {
    $clusters = $clusterManagerClient->listClusters($projectId, $zone);
    foreach ($clusters->getClusters() as $cluster) {
        print('Cluster: ' . $cluster->getName() . PHP_EOL);
    }
} finally {
    $clusterManagerClient->close();
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

Take a look at and understand the [official documentation](https://cloud.google.com/kubernetes-engine/docs).
