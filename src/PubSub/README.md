# Google Cloud PHP PubSub

> Idiomatic PHP client for [Cloud Pub/Sub](https://cloud.google.com/pubsub/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-pubsub/v/stable)](https://packagist.org/packages/google/cloud-pubsub) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-pubsub.svg)](https://packagist.org/packages/google/cloud-pubsub)

* [Homepage](http://googlecloudplatform.github.io/google-cloud-php)
* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-pubsub/latest/pubsub/pubsubclient)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

If gRPC is not installed, this client uses REST over HTTP/1.1. For improved performance, or to make use of the generated clients, we recommend installing the gRPC PHP extension. For installation instructions, [see here](https://cloud.google.com/php/grpc).

NOTE: In addition to the gRPC extension, we recommend installing the protobuf extension for improved performance. For installation instructions, [see here](https://cloud.google.com/php/grpc#install_the_protobuf_runtime_library).

## Installation

```
$ composer require google/cloud-pubsub
```
