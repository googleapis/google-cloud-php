# Google Cloud Run for PHP

> Idiomatic PHP client for [Google Cloud Run](https://cloud.google.com/run).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-run/v/stable)](https://packagist.org/packages/google/cloud-run) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-run.svg)](https://packagist.org/packages/google/cloud-run)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-run/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just run:

```sh
$ composer require google/cloud-run
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/run/docs).
