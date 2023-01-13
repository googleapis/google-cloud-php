# Google Cloud Dialogflow for PHP

> Idiomatic PHP client for [Google Cloud Dialogflow](https://cloud.google.com/dialogflow-enterprise/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-dialogflow/v/stable)](https://packagist.org/packages/google/cloud-dialogflow) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-dialogflow.svg)](https://packagist.org/packages/google/cloud-dialogflow)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-dialogflow/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Dialogflow Enterprise Edition is the enterprise tier of Dialogflow which is a natural language understanding platform
that makes it easy for you to design and integrate a conversational user interface into your mobile app, web application,
device, bot, and so on. Using Dialogflow you can provide users new and engaging ways to interact with your product using
both voice recognition and text input.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-dialogflow
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

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Dialogflow\V2\EntityTypesClient;

$entityTypesClient = new EntityTypesClient();
$projectId = '[MY_PROJECT_ID]';
$entityTypeId = '[ENTITY_TYPE_ID]';
$formattedEntityTypeName = $entityTypesClient->entityTypeName($projectId, $entityTypeId);

$entityType = $entityTypesClient->getEntityType($formattedEntityTypeName);
foreach ($entityType->getEntities() as $entity) {
    print(PHP_EOL);
    printf('Entity value: %s' . PHP_EOL, $entity->getValue());
    print('Synonyms: ');
    foreach ($entity->getSynonyms() as $synonym) {
        print($synonym . "\t");
    }
    print(PHP_EOL);
}
```

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/dialogflow-enterprise/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/dialogflow).
