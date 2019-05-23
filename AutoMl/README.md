# Cloud AutoML for PHP

> Idiomatic PHP client for [Cloud AutoML](https://cloud.google.com/automl).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-automl/v/stable)](https://packagist.org/packages/google/cloud-automl) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-automl.svg)](https://packagist.org/packages/google/cloud-automl)

* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-automl/latest/automl/readme)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-automl
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/GoogleCloudPlatform/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Cloud\AutoMl\V1beta1\TranslationDatasetMetadata;

$autoMlClient = new AutoMlClient();
$formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
$dataset = new Dataset([
    'display_name' => '[DISPLAY_NAME]',
    'translation_dataset_metadata' => new TranslationDatasetMetadata([
        'source_language_code' => 'en',
        'target_language_code' => 'es'
    ])
]);
$response = $autoMlClient->createDataset($formattedParent, $dataset);
```

### Version

This component is considered beta. As such, it is still a work-in-progress and is more likely to get backwards-incompatible updates.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/automl/docs).
