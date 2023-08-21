# Google Cloud Security Command Center for PHP

> Idiomatic PHP client for [Google Cloud Security Command Center](https://cloud.google.com/security-command-center).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-security-center/v/stable)](https://packagist.org/packages/google/cloud-security-center) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-security-center.svg)](https://packagist.org/packages/google/cloud-security-center)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-security-center/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-security-center
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\Source;

$security = new SecurityCenterClient();
$parent = SecurityCenterClient::organizationName('[YOUR ORGANIZATION]');
$source = new Source([
    'name' => SecurityCenterClient::sourceName('[YOUR ORGANIZATION]', '[YOUR SOURCE]'),
    'displayName' => '[YOUR SOURCE]'
]);

$res = $security->createSource($parent, $source);
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/security-command-center/docs).
