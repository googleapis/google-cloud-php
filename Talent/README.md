# Google Cloud Talent Solution for PHP

> Idiomatic PHP client for [Google Cloud Talent Solution](https://cloud.google.com/solutions/talent-solution/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-talent/v/stable)](https://packagist.org/packages/google/cloud-talent) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-talent.svg)](https://packagist.org/packages/google/cloud-talent)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-talent/latest/talent/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-talent
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Talent\V4beta1\Company;
use Google\Cloud\Talent\V4beta1\CompanyServiceClient;

$client = new CompanyServiceClient();
$response = $client->createCompany(
    CompanyServiceClient::projectName('spaceman-spiff2'),
    new Company([
        'display_name' => 'Google, LLC',
        'external_id' => 1,
        'headquarters_address' => '1600 Amphitheatre Parkway, Mountain View, CA'
    ])
);
```

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/talent-solution/job-search/docs/apis).
