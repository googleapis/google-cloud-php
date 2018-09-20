# Google Cloud Vision for PHP

> Idiomatic PHP client for [Cloud Vision](https://cloud.google.com/vision/).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-vision/v/stable)](https://packagist.org/packages/google/cloud-vision) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-vision.svg)](https://packagist.org/packages/google/cloud-vision)

* [API documentation](http://googleapis.github.io/google-cloud-php/#/docs/cloud-vision/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows developers to easily integrate vision detection features within applications, including image labeling, face and
landmark detection, optical character recognition (OCR), and tagging of explicit content.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just this component:

```sh
$ composer require google/cloud-vision
```

Or to install the entire suite of components at once:

```sh
$ composer require google/cloud
```

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Vision\VisionClient;

$vision = new VisionClient();

// Annotate an image, detecting faces.
$image = $vision->image(
    fopen('/data/family_photo.jpg', 'r'),
    ['faces']
);

$annotation = $vision->annotate($image);

// Determine if the detected faces have headwear.
foreach ($annotation->faces() as $key => $face) {
    if ($face->hasHeadwear()) {
        echo "Face $key has headwear.\n";
    }
}
```

### Version

This component is considered beta. As such, it should be expected to be mostly
stable and we're working towards a release candidate. We will address issues
and requests with a higher priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/vision/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/vision/).

