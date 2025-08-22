# Google Cloud Vision for PHP

> Idiomatic PHP client for [Cloud Vision](https://cloud.google.com/vision/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-vision/v/stable)](https://packagist.org/packages/google/cloud-vision) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-vision.svg)](https://packagist.org/packages/google/cloud-vision)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-vision/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows developers to easily integrate vision detection features within applications, including image labeling, face and
landmark detection, optical character recognition (OCR), and tagging of explicit content.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-vision
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\Likelihood;

$client = new ImageAnnotatorClient();

// Prepare the request
$content = file_get_contents('/data/photos/family-photo.jpg', 'r');
$image = (new Image())
    ->setContent($content);
$feature = (new Feature())
    ->setType(Feature\Type::FACE_DETECTION);
$request = (new AnnotateImageRequest())
    ->setImage($image)
    ->setFeatures([$feature]);
$batchRequest = (new BatchAnnotateImagesRequest())
    ->setRequests([$request]);

// Annotate an image, detecting faces.
$batchResponse = $client->batchAnnotateImages($batchRequest);

// Determine if the detected faces have headwear.
foreach ($batchResponse->getResponses() as $response) {
    foreach ($response->getFaceAnnotations() as $faceAnnotation) {
        $likelihood = Likelihood::name($faceAnnotation->getHeadwearLikelihood());
        echo "Likelihood of headwear: $likelihood" . PHP_EOL;
    }
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/vision/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/vision/).
