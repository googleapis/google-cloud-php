# reCAPTCHA Enterprise for PHP

> Idiomatic PHP client for [reCAPTCHA Enterprise](https://cloud.google.com/recaptcha-enterprise/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-recaptcha-enterprise/v/stable)](https://packagist.org/packages/google/cloud-recaptcha-enterprise) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-recaptcha-enterprise.svg)](https://packagist.org/packages/google/cloud-recaptcha-enterprise)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-recaptcha-enterprise/latest/recaptchaenterprise/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-recaptcha-enterprise
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
use Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1beta1\Event;
use Google\Cloud\RecaptchaEnterprise\V1beta1\RecaptchaEnterpriseServiceV1Beta1Client;

$recaptcha = new RecaptchaEnterpriseServiceV1Beta1Client;
$recaptcha->createAssessment([
    'parent' => RecaptchaEnterpriseServiceV1Beta1Client::projectName('[PROJECT_ID]'),
    'assessment' => new Assessment([
        'event' => new Event([
            'token' => '[EVENT_TOKEN]',
            'site_key' => '[SITE_KEY]'
        ])
    ])
]);
```

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/recaptcha-enterprise/docs).
