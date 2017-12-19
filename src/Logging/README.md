# Google Cloud PHP Logging

> Idiomatic PHP client for [Stackdriver Logging](https://cloud.google.com/logging/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-logging/v/stable)](https://packagist.org/packages/google/cloud-logging) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-logging.svg)](https://packagist.org/packages/google/cloud-logging)

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-logging/latest/logging/loggingclient)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

If gRPC is not installed, this client uses REST over HTTP/1.1. For improved performance, or to make use of the generated clients, we recommend installing the gRPC PHP extension. For installation instructions, [see here](https://cloud.google.com/php/grpc).

NOTE: In addition to the gRPC extension, we recommend installing the protobuf extension for improved performance. For installation instructions, [see here](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library).

## Installation

```
$ composer require google/cloud-logging
```
