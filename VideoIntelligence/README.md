# Google Cloud Video Intelligence for PHP

[![Latest Stable Version](https://poser.pugx.org/google/cloud-videointelligence/v/stable)](https://packagist.org/packages/google/cloud-videointelligence) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-videointelligence.svg)](https://packagist.org/packages/google/cloud-videointelligence)

* [API documentation](http://googlecloudplatform.github.io/google-cloud-php/#/docs/cloud-videointelligence/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googlecloudplatform/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows developers to use Google video analysis technology as part of their applications. The REST API enables users to
annotate videos stored locally or in Google Cloud Storage with contextual information at the level of the entire video,
per segment, per shot, and per frame.

**NOTE:** This documentation covers the most recent stable release (V1). There is an additional beta release included
in this component. To check out its documentation, see the link below:

* [VideoIntelligence V1beta2 client](https://googlecloudplatform.github.io/google-cloud-php/#/docs/google-cloud/latest/videointelligence/v1beta2/videointelligenceserviceclient)

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-videointelligence
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
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\VideoIntelligence\V1\VideoIntelligenceServiceClient;
use Google\Cloud\VideoIntelligence\V1\Feature;

$videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();

$inputUri = "gs://example-bucket/example-video.mp4";
$features = [
    Feature::LABEL_DETECTION,
];
$operationResponse = $videoIntelligenceServiceClient->annotateVideo($inputUri, $features);
$operationResponse->pollUntilComplete();
if ($operationResponse->operationSucceeded()) {
    $results = $operationResponse->getResult();
    foreach ($results->getAnnotationResultsList() as $result) {
        foreach ($result->getLabelAnnotationsList() as $labelAnnotation) {
            echo "Label: " . $labelAnnotation->getDescription() . "\n";
        }
    }
} else {
    $error = $operationResponse->getError();
    echo "error: " . $error->getMessage() . "\n";
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/video-intelligence/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/video/).

