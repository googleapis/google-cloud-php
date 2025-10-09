# Google Cloud Video Intelligence for PHP

> Idiomatic PHP client for [Cloud Video Intelligence](https://cloud.google.com/video-intelligence/)

[![Latest Stable Version](https://poser.pugx.org/google/cloud-videointelligence/v/stable)](https://packagist.org/packages/google/cloud-videointelligence) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-videointelligence.svg)](https://packagist.org/packages/google/cloud-videointelligence)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-videointelligence/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

Allows developers to use Google video analysis technology as part of their applications. The REST API enables users to
annotate videos stored locally or in Google Cloud Storage with contextual information at the level of the entire video,
per segment, per shot, and per frame.

**NOTE:** This documentation covers the most recent stable release (V1). There is an additional beta release included
in this component. To check out its documentation, see the link below:

* [VideoIntelligence](https://cloud.google.com/php/docs/reference/cloud-videointelligence/latest))

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now install this component:

```sh
$ composer require google/cloud-videointelligence
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoRequest;
use Google\Cloud\VideoIntelligence\V1\AnnotateVideoResponse;
use Google\Cloud\VideoIntelligence\V1\Client\VideoIntelligenceServiceClient;
use Google\Rpc\Status;

// Create a client.
$videoIntelligenceServiceClient = new VideoIntelligenceServiceClient();

// Prepare the request message.
$request = new AnnotateVideoRequest();

// Call the API and handle any network failures.
try {
    /** @var OperationResponse $response */
    $response = $videoIntelligenceServiceClient->annotateVideo($request);
    $response->pollUntilComplete();

    if ($response->operationSucceeded()) {
        /** @var AnnotateVideoResponse $result */
        $result = $response->getResult();
        printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
    } else {
        /** @var Status $error */
        $error = $response->getError();
        printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
    }
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/video-intelligence/docs/).
2. Take a look at [in-depth usage samples](https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/video/).
