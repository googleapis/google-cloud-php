# Cloud Firestore for PHP

> Idiomatic PHP client for [Cloud Firestore](https://cloud.google.com/firestore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-firestore/v/stable)](https://packagist.org/packages/google/cloud-firestore) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-firestore.svg)](https://packagist.org/packages/google/cloud-firestore)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-firestore/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A NoSQL document database built for automatic scaling, high performance, and
ease of application development. While the Cloud Firestore interface has many of
the same features as traditional databases, as a NoSQL database it differs from
them in the way it describes relationships between data objects.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-firestore
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component requires the gRPC extension. Please see our [gRPC installation guide](https://cloud.google.com/php/grpc)
for more information on how to configure the extension.

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;

$firestore = new FirestoreClient();

$collectionReference = $firestore->collection('Users');
$documentReference = $collectionReference->document($userId);
$snapshot = $documentReference->snapshot();

echo "Hello " . $snapshot['firstName'];
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/firestore/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/firestore).
