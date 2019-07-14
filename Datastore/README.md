# Google Cloud PHP Datastore

> Idiomatic PHP client for [Cloud Datastore](https://cloud.google.com/datastore/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-datastore/v/stable)](https://packagist.org/packages/google/cloud-datastore) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-datastore.svg)](https://packagist.org/packages/google/cloud-datastore)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-datastore/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

A NoSQL document database built for automatic scaling, high performance, and
ease of application development. While the Cloud Datastore interface has many of
the same features as traditional databases, as a NoSQL database it differs from
them in the way it describes relationships between data objects.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-datastore
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$datastore = new DatastoreClient();

// Create an entity
$bob = $datastore->entity('Person');
$bob['firstName'] = 'Bob';
$bob['email'] = 'bob@example.com';
$datastore->insert($bob);

// Update the entity
$bob['email'] = 'bobV2@example.com';
$datastore->update($bob);

// If you know the ID of the entity, you can look it up
$key = $datastore->key('Person', '12345328897844');
$entity = $datastore->lookup($key);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Compatibility with Google App Engine

This component is compatible with PHP projects on Google App Engine in the Standard or Flexible environments. To maximize the performance of datastore operations in your app, we recommend the following configuration:
1. PHP 7 runtime
2. Enable grpc.so and protobuf.so in your php.ini file
3. Set your DatastoreClient object's 'transport' option to 'grpc'

You are likely to experience less optimal datastore performance using the PHP 5 runtime on App Engine standard due to the lack of the protobuf extension.


### Next Steps

1. Understand the [official documentation](https://cloud.google.com/datastore/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/datastore).
