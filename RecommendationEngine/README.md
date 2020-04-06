# Google Cloud Recommendation Engine for PHP

> Idiomatic PHP client for [Google Cloud Recommendation Engine](https://cloud.google.com/recommendation-engine).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-recommendation-engine/v/stable)](https://packagist.org/packages/google/cloud-recommendation-engine) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-recommendation-engine.svg)](https://packagist.org/packages/google/cloud-recommendation-engine)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-recommendation-engine/latest/recommendationengine/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-recommendation-engine
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
use Google\Cloud\RecommendationEngine\V1beta1\PredictionServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\UserEvent;

$client = new PredictionServiceClient();
$formattedName = $predictionServiceClient->placementName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[EVENT_STORE]', '[PLACEMENT]');
$userEvent = new UserEvent();

$predictions = $predictionServiceClient->predict($formattedName, $userEvent);
```

### Version

This component is considered alpha. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/recommendation-engine/docs).
