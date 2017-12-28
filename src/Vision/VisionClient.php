<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Vision;

use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Vision\Connection\Rest;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Google Cloud Vision allows you to understand the content of an image,
 * classify images into categories, detect text, objects, faces and more. Find
 * more information at the
 * [Google Cloud Vision docs](https://cloud.google.com/vision/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 * ```
 */
class VisionClient
{
    use ClientTrait;
    use ValidateTrait;

    const VERSION = '0.8.2';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a Vision client.
     *
     * Note that when creating a VisionClient instance, setting
     * `$config.projectId` is not supported. To switch between projects, you
     * must provide credentials with access to the project.
     *
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws Google\Cloud\Core\Exception\GoogleException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Create an instance of {@see Google\Cloud\Vision\Image} with required features and options.
     *
     * This method should be used to configure a single image, or when a set of
     * images requires different settings for each member of the set. If you
     * have a set of images which all will use the same settings,
     * {@see Google\Cloud\Vision\VisionClient::images()} may be quicker and
     * simpler to use.
     *
     * This method will not perform any service requests, and is meant to be
     * used to configure a request prior to calling
     * {@see Google\Cloud\Vision\VisionClient::annotate()}.
     *
     * For more information, including best practices and examples detailing
     * other usage such as `$imageContext`, see {@see Google\Cloud\Vision\Image::__construct()}.
     *
     * Example:
     * ```
     * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($imageResource, [
     *     'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // Setting maxResults for a feature
     *
     * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($imageResource, [
     *     'FACE_DETECTION'
     * ], [
     *     'maxResults' => [
     *         'FACE_DETECTION' => 1
     *     ]
     * ]);
     * ```
     *
     * @param  resource|string|StorageObject $image An image to configure with
     *         the given settings. This parameter will accept a resource, a
     *         string of bytes, the URI of an image in a publicly-accessible
     *         web location, or an instance of {@see Google\Cloud\Storage\StorageObject}.
     * @param  array $features A list of cloud vision
     *         [features](https://cloud.google.com/vision/reference/rest/v1/images/annotate#type)
     *         to apply to the image.
     * @param  array $options See {@see Google\Cloud\Vision\Image::__construct()} for
     *         configuration details.
     * @return Image
     * @throws InvalidArgumentException
     */
    public function image($image, array $features, array $options = [])
    {
        return new Image($image, $features, $options);
    }

    /**
     * Create an array of type {@see Google\Cloud\Vision\Image} with required features and options set for
     * each member of the set.
     *
     * This method is useful for quickly configuring every member of a set of
     * images with the same features and options. Should you need to provide
     * different features or options for one or more members of the set,
     * {@see Google\Cloud\Vision\VisionClient::image()} is a better choice.
     *
     * This method will not perform any service requests, and is meant to be
     * used to configure a request prior to calling
     * {@see Google\Cloud\Vision\VisionClient::annotateBatch()}.
     *
     * For more information, including best practices and examples detailing
     * other usage such as `$imageContext`, see {@see Google\Cloud\Vision\Image::__construct()}.
     *
     * Example:
     * ```
     * // In the example below, both images will have the same settings applied.
     * // They will both run face detection and return up to 10 results.
     *
     * $familyPhotoResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     * $weddingPhotoResource = fopen(__DIR__ . '/assets/wedding-photo.jpg', 'r');
     *
     * $images = $vision->images([$familyPhotoResource, $weddingPhotoResource], [
     *     'FACE_DETECTION'
     * ], [
     *     'maxResults' => [
     *         'FACE_DETECTION' => 10
     *     ]
     * ]);
     * ```
     *
     * @param  resource[]|string[]|StorageObject[] $images An array of images
     *         to configure with the given settings. Each member of the set can
     *         be a resource, a string of bytes, the URI of an image in a
     *         publicly-accessible web location, or an instance of
     *         {@see Google\Cloud\Storage\StorageObject}.
     * @param  array $features A list of cloud vision features to apply to each image.
     * @param  array $options See {@see Google\Cloud\Vision\Image::__construct()} for
     *         configuration details.
     * @return Image[]
     * @throws InvalidArgumentException
     */
    public function images(array $images, array $features, array $options = [])
    {
        $result = [];
        foreach ($images as $image) {
            $result[] = $this->image($image, $features, $options);
        }

        return $result;
    }

    /**
     * Annotate a single image.
     *
     * Example:
     * ```
     * $familyPhotoResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($familyPhotoResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $result = $vision->annotate($image);
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate Annotate API documentation
     *
     * @param  Image $image The image to annotate
     * @param  array $options Configuration options
     * @return Annotation
     */
    public function annotate(Image $image, array $options = [])
    {
        $res = $this->annotateBatch([$image], $options);
        return $res[0];
    }

    /**
     * Annotate a set of images.
     *
     * Example:
     * ```
     * $images = [];
     *
     * $familyPhotoResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     * $eiffelTowerResource = fopen(__DIR__ . '/assets/eiffel-tower.jpg', 'r');
     *
     * $images[] = $vision->image($familyPhotoResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $images[] = $vision->image($eiffelTowerResource, [
     *     'LANDMARK_DETECTION'
     * ]);
     *
     * $result = $vision->annotateBatch($images);
     * ```
     *
     * @see https://cloud.google.com/vision/docs/reference/rest/v1/images/annotate Annotate API documentation
     *
     * @param  Image[] $images An array consisting of instances of
     *         {@see Google\Cloud\Vision\Image}.
     * @param  array $options Configuration Options
     * @return Annotation[]
     */
    public function annotateBatch(array $images, array $options = [])
    {
        $this->validateBatch($images, Image::class);

        $requests = [];
        foreach ($images as $image) {
            $requests[] = $image->requestObject();
        }

        $res = $this->connection->annotate([
            'requests' => $requests
        ] + $options);

        $annotations = [];
        if (isset($res['responses'])) {
            foreach ($res['responses'] as $response) {
                $annotations[] = new Annotation($response);
            }
        }

        return $annotations;
    }
}
