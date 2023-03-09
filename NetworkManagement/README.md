# Google Cloud Network Management for PHP

> Idiomatic PHP client for [Google Cloud Network Management](https://cloud.google.com/network-intelligence-center/docs/connectivity-tests/reference/networkmanagement/rest).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-network-management/v/stable)](https://packagist.org/packages/google/cloud-network-management) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-network-management.svg)](https://packagist.org/packages/google/cloud-network-management)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-network-management/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-network-management
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

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/network-intelligence-center/docs/connectivity-tests/reference/networkmanagement/rest).
