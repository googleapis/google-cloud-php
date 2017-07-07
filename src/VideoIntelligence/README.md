# Google Cloud PHP Video Intelligence

> Idiomatic PHP client for [Cloud Video Intelligence](https://cloud.google.com/video-intelligence/).

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-videointelligence/latest/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

This client supports transport over gRPC. In order to enable gRPC support please make sure to install and enable
the gRPC extension through PECL:

```sh
$ pecl install grpc
```

If you are using Video Intelligence through the umbrella package (google/cloud),
you will also need to install the following dependencies through composer:

```sh
$ composer require google/gax && composer require google/proto-client
```

Please take care in installing the same version of these libraries that are
outlined in the project's composer.json require-dev keyword.

NOTE: Support for gRPC is currently at an Alpha quality level, meaning it is still
a work in progress and is more likely to get backwards-incompatible updates.

## Installation

```
$ composer require google/cloud-videointelligence
```
