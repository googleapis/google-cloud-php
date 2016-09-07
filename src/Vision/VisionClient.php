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

use Google\Cloud\ClientTrait;
use Google\Cloud\Vision\Connection\Rest;
use InvalidArgumentException;

/**
 * Google Cloud Vision client. Allows you to understand the content of an image,
 * classify images into categories, detect text, objects, faces and more. Find
 * more information at
 * [Google Cloud Vision docs](https://cloud.google.com/vision/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $vision = $cloud->vision();
 * ```
 */
class VisionClient
{
    use ClientTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a Vision client.
     *
     * Example:
     * ```
     * use Google\Cloud\Vision\VisionClient;
     *
     * $vision = new VisionClient();
     * ```
     *
     * @param array $config {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws Google\Cloud\Exception\GoogleException
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
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($imageResource, [
     *     'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // Setting maxResults for a feature
     *
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($imageResource, [
     *     'FACE_DETECTION'
     * ], [
     *     'maxResults' => [
     *         'FACE_DETECTION' => 1
     *     ]
     * ])
     * ```
     *
     * @param  resource|string|StorageObject $image An image to configure with
     *         the given settings. This parameter will accept a resource, a
     *         string of bytes, or an instance of
     *         {@see Google\Cloud\Storage\StorageObject}.
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
     * $familyPhotoResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $weddingPhotoResource = fopen(__DIR__ .'/assets/wedding-photo.jpg', 'r');
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
     *         be a resource, a string of bytes, or an instance of
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
     * $familyPhotoResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     *
     * $image = $vision->image($familyPhotoResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $result = $vision->annotate($image);
     * ```
     *
     * @param  Image $image The image to annotate
     * @param  array $options Configuration options
     * @return Annotation
     */
    public function annotate(Image $image, array $options = [])
    {
        $res = $this->annotateBatch([$image], $options);
        $res->rewind();
        return $res->current();
    }

    /**
     * Annotate a set of images.
     *
     * Example:
     * ```
     * $images = [];
     *
     * $familyPhotoResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $images[] = $vision->image($familyPhotoResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $eiffelTowerResource = fopen(__DIR__ .'/assets/eiffel-tower.jpg', 'r');
     * $images[] = $vision->image($eiffelTowerResource, [
     *     'LANDMARK_DETECTION'
     * ]);
     *
     * $result = $vision->annotateBatch($images);
     * ```
     *
     * @param  Image[] $images An array consisting of instances of
     *         {@see Google\Cloud\Vision\Image}.
     * @param  array $options Configuration Options
     * @return \Generator<Google\Cloud\Vision\Annotation>
     */
    public function annotateBatch(array $images, array $options = [])
    {
        $requests = [];
        foreach ($images as $image) {
            if (!$image instanceof Image) {
                throw new InvalidArgumentException('$images must be of type Image[].');
            }

            $requests[] = $image->requestObject();
        }

        $res = $this->connection->annotate([
            'requests' => $requests
        ] + $options);

        return $this->respond($res);
    }

    /**
     * Generate a response to an annotation request.
     *
     * @param array $res The response object
     * @return \Generator<Google\Cloud\Vision\Annotation>
     */
    private function respond(array $res)
    {
        if (isset($res['responses'])) {
            foreach ($res['responses'] as $response) {
                yield new Annotation($response);
            }
        }
    }
}
