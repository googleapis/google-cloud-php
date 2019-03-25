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

use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Psr7;
use InvalidArgumentException;

/**
 * Represents an image to be annotated using
 * [Google Cloud Vision](https://cloud.google.com/vision).
 *
 * Please review [Pricing](https://cloud.google.com/vision/docs/pricing)
 * before use, as a separate charge is incurred for each feature performed
 * on an image. When practical, caching of results is certainly recommended.
 *
 * The Cloud Vision API supports a variety of image file formats, including
 * JPEG, PNG8, PNG24, Animated GIF (first frame only), and RAW.
 *
 * Cloud Vision sets upper limits on file size as well as on the total
 * combined size of all images in a request. Reducing your file size can
 * significantly improve throughput; however, be careful not to reduce image
 * quality in the process. See
 * [Best Practices - Image Sizing](https://cloud.google.com/vision/docs/best-practices#image_sizing)
 * for current file size limits.
 *
 * Example:
 * ```
 * //[snippet=default]
 * use Google\Cloud\Vision\VisionClient;
 *
 * $vision = new VisionClient();
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = $vision->image($imageResource, [
 *     'FACE_DETECTION'
 * ]);
 * ```
 *
 * ```
 * //[snippet=direct]
 * // Images can be directly instantiated.
 * use Google\Cloud\Vision\Image;
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = new Image($imageResource, [
 *     'FACE_DETECTION'
 * ]);
 * ```
 *
 * ```
 * //[snippet=string]
 * // Image data can be given as a string
 *
 * use Google\Cloud\Vision\Image;
 *
 * $imageData = file_get_contents(__DIR__ .'/assets/family-photo.jpg');
 * $image = new Image($imageData, [
 *    'FACE_DETECTION'
 * ]);
 * ```
 *
 * ```
 * //[snippet=gcs]
 * // Files stored in Google Cloud Storage can be used.
 * use Google\Cloud\Storage\StorageClient;
 * use Google\Cloud\Vision\Image;
 *
 * $storage = new StorageClient();
 * $file = $storage->bucket('my-test-bucket')->object('family-photo.jpg');
 * $image = new Image($file, [
 *     'FACE_DETECTION'
 * ]);
 * ```
 *
 * ```
 * //[snippet=max]
 * // This example sets a maximum results limit on one feature and provides some image context.
 *
 * use Google\Cloud\Vision\Image;
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = new Image($imageResource, [
 *     'FACE_DETECTION',
 *     'LOGO_DETECTION'
 * ], [
 *     'maxResults' => [
 *         'FACE_DETECTION' => 1
 *     ],
 *     'imageContext' => [
 *         'latLongRect' => [
 *             'minLatLng' => [
 *                 'latitude' => '-45.0',
 *                 'longitude' => '-45.0'
 *             ],
 *             'maxLatLng' => [
 *                 'latitude' => '45.0',
 *                 'longitude' => '45.0'
 *             ]
 *         ]
 *     ]
 * ]);
 * ```
 *
 * ```
 * //[snippet=shortcut]
 * // The client library also offers shortcut names which can be used in place of the longer feature names.
 *
 * use Google\Cloud\Vision\Image;
 *
 * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
 * $image = new Image($imageResource, [
 *     'faces',          // Corresponds to `FACE_DETECTION`
 *     'landmarks',      // Corresponds to `LANDMARK_DETECTION`
 *     'logos',          // Corresponds to `LOGO_DETECTION`
 *     'labels',         // Corresponds to `LABEL_DETECTION`
 *     'text',           // Corresponds to `TEXT_DETECTION`,
 *     'document',       // Corresponds to `DOCUMENT_TEXT_DETECTION`
 *     'safeSearch',     // Corresponds to `SAFE_SEARCH_DETECTION`
 *     'imageProperties',// Corresponds to `IMAGE_PROPERTIES`
 *     'crop',           // Corresponds to `CROP_HINTS`
 *     'web'             // Corresponds to `WEB_DETECTION`
 * ]);
 * ```
 *
 * @see https://cloud.google.com/vision/docs/best-practices Best Practices
 * @see https://cloud.google.com/vision/docs/pricing Pricing
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Image
{
    const TYPE_BYTES = 'bytes';
    const TYPE_STRING = 'string';
    const TYPE_URI = 'uri';

    /**
     * @var mixed
     */
    private $image;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $features;

    /**
     * @var array
     */
    private $options;

    /**
     * A map of short names to identifiers recognized by Cloud Vision.
     *
     * @var array
     */
    private $featureShortNames = [
        'faces'           => 'FACE_DETECTION',
        'landmarks'       => 'LANDMARK_DETECTION',
        'logos'           => 'LOGO_DETECTION',
        'labels'          => 'LABEL_DETECTION',
        'text'            => 'TEXT_DETECTION',
        'document'        => 'DOCUMENT_TEXT_DETECTION',
        'safeSearch'      => 'SAFE_SEARCH_DETECTION',
        'imageProperties' => 'IMAGE_PROPERTIES',
        'crop'            => 'CROP_HINTS',
        'web'             => 'WEB_DETECTION'
    ];

    /**
     * A list of allowed url schemes.
     *
     * @var array
     */
    private $urlSchemes = [
        'http',
        'https',
        'gs'
    ];

    /**
     * Create an image with all required configuration.
     *
     * @param  resource|string|StorageObject $image An image to configure with
     *         the given settings. This parameter will accept a resource, a
     *         string of bytes, the URI of an image in a publicly-accessible
     *         web location, or an instance of {@see Google\Cloud\Storage\StorageObject}.
     * @param  array $features A list of cloud vision
     *         [features](https://cloud.google.com/vision/reference/rest/v1/images/annotate#type)
     *         to apply to the image. Google Cloud Platform Client Library provides a set of abbreviated
     *         names which can be used in the interest of brevity in place of
     *         the names offered by the cloud vision service. These names are
     *         `faces`, `landmarks`, `logos`, `labels`, `text`, `document`,
     *         `safeSearch`, `imageProperties`, `crop`, and `web`.
     * @param  array $options {
     *     Configuration Options
     *
     *     @type array $maxResults A list of features and the maximum number of
     *           results to return. Keys should correspond to feature names
     *           given in the `$features` array, and values should be of type
     *           int. In all cases where `$maxResults` does not contain a value
     *           for a feature, all results will be returned. In cases where
     *           a `$maxResults` value is specified, the cloud vision service
     *           will return results up to the `$maxResults` value, or the full
     *           results, whichever is fewer.
     *     @type array $imageContext See
     *           [ImageContext](https://cloud.google.com/vision/reference/rest/v1/images/annotate#imagecontext)
     *           for full usage details.
     * }
     * @throws InvalidArgumentException
     */
    public function __construct($image, array $features, array $options = [])
    {
        $this->options = $options + [
            'imageContext' => [],
            'maxResults' => []
        ];

        $this->features = $this->normalizeFeatures($features);

        $this->image = $image;
        if (is_string($image) && in_array(parse_url($image, PHP_URL_SCHEME), $this->urlSchemes)) {
            $this->type = self::TYPE_URI;
        } elseif (is_string($image)) {
            $this->type = self::TYPE_STRING;
        } elseif ($image instanceof StorageObject) {
            $this->type = self::TYPE_URI;
            $this->image = $image->gcsUri();
        } elseif (is_resource($image)) {
            $this->type = self::TYPE_BYTES;
            $this->image = Psr7\stream_for($image);
        } else {
            throw new InvalidArgumentException(
                'Given image is not valid. ' .
                'Image must be a string of bytes, a google storage object, a valid image URI, or a resource.'
            );
        }

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }

    /**
     * Return a formatted annotate image request.
     *
     * This method is used internally by {@see Google\Cloud\Vision\VisionClient}
     * and is not generally intended for use outside of that context.
     *
     * Example:
     * ```
     * use Google\Cloud\Vision\Image;
     *
     * $imageResource = fopen(__DIR__ . '/assets/family-photo.jpg', 'r');
     * $image = new Image($imageResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $requestObj = $image->requestObject();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#annotateimagerequest AnnotateImageRequest
     *
     * @param  bool $encode [optional] If set to true, image bytes will be base64-encoded
     *         (required for json/rest requests)
     * @return array
     */
    public function requestObject($encode = true)
    {
        return array_filter([
            'image' => $this->imageObject($encode),
            'features' => $this->features,
            'imageContext' => $this->options['imageContext']
        ]);
    }

    /**
     * Create an image object.
     *
     * The structure of the returned array will vary depending on whether the
     * given image is a storage object or not.
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#image Image
     *
     * @param  bool $encode If set to true, image bytes will be base64-encoded
     * @return array [Image](https://cloud.google.com/vision/reference/rest/v1/images/annotate#image)
     */
    private function imageObject($encode)
    {
        if ($this->type === self::TYPE_BYTES) {
            $bytes = (string) $this->image;

            return [
                'content' => ($encode) ? base64_encode($bytes) : $bytes
            ];
        }

        if ($this->type === self::TYPE_STRING) {
            $string = $this->image;

            return [
                'content' => ($encode) ? base64_encode($string) : $string
            ];
        }

        return [
            'source' => [
                'imageUri' => $this->image
            ]
        ];
    }

    /**
     * Normalizes short feature names to identifiers compatible with the vision
     * API and adds maxResults if specified.
     *
     * @param  array $features
     * @return array A list of type [Feature](https://cloud.google.com/vision/reference/rest/v1/images/annotate#feature)
     */
    private function normalizeFeatures(array $features)
    {
        $result = [];

        foreach ($features as $key => $feature) {
            $maxResults = $this->maxResult($feature);

            if (array_key_exists($feature, $this->featureShortNames)) {
                $feature = $this->featureShortNames[$feature];
            }

            $result[] = array_filter([
                'type' => $feature,
                'maxResults' => $maxResults
            ]);
        }

        return $result;
    }

    /**
     * Identify and return a maxResults value for a given feature, if maxResults
     * is specified.
     *
     * @param  string $feature
     * @return mixed Int if set, null if not set.
     */
    private function maxResult($feature)
    {
        return (isset($this->options['maxResults'][$feature]))
            ? $this->options['maxResults'][$feature]
            : null;
    }
}
