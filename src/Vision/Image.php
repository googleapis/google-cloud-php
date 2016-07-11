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

use Google\Cloud\Storage\Object;
use Guzzle\Stream\Stream;

/**
 * Represents an image to be annotated using
 * [Google Cloud Vision](https://cloud.google.com/vision)
 */
class Image
{
    const TYPE_BYTES = 'bytes';
    const TYPE_STORAGE = 'storage';
    const TYPE_STRING = 'string';

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
     * @var array
     */
    private $featureShortNames = [
        'faces'      => 'FACE_DETECTION',
        'landmarks'  => 'LANDMARK_DETECTION',
        'logos'      => 'LOGO_DETECTION',
        'labels'     => 'LABEL_DETECTION',
        'text'       => 'TEXT_DETECTION',
        'safeSearch' => 'SAFE_SEARCH_DETECTION',
        'properties' => 'IMAGE_PROPERTIES'
    ];

    /**
     * Create an image with all required configuration.
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
     * [Best Practices - Image Sizing](https://cloud.google.com/vision/docs/image-best-practices#image_sizing)
     * for current file size limits.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder();
     * $vision = $cloud->vision();
     *
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $image = $vision->image($imageResource, [
     *     'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // Images can be created directly
     * use Google\Cloud\Vision\Image;
     *
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $image = new Image($imageResource, [
     *     'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // Image data can be given as a string
     *
     * $fileContents = file_get_contents(__DIR__ .'/assets/family-photo.jpg');
     * $image = new Image($fileContents, [
     *    'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // Files stored in Google Cloud Storage can be used.
     *
     * $file = $cloud->storage()->bucket('my-test-bucket')->object('family-photo.jpg');
     * $image = $vision->image($file, [
     *     'FACE_DETECTION'
     * ]);
     * ```
     *
     * ```
     * // This example sets a maximum results limit on one feature and provides some image context.
     *
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $image = $vision->image($imageResource, [
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
     * // gcloud-php also offers shortcut names which can be used in place of the longer feature names.
     * $image = new Image($imageResource, [
     *     'faces',      // Corresponds to `FACE_DETECTION`
     *     'landmarks',  // Corresponds to `LANDMARK_DETECTION`
     *     'logos',      // Corresponds to `LOGO_DETECTION`
     *     'labels',     // Corresponds to `LABEL_DETECTION`
     *     'text',       // Corresponds to `TEXT_DETECTION`
     *     'safeSearch', // Corresponds to `SAFE_SEARCH_DETECTION`
     *     'properties'  // Corresponds to `IMAGE_PROPERTIES`
     * ]);
     * ```
     *
     * @see https://cloud.google.com/vision/docs/image-best-practices Best Practices
     * @see https://cloud.google.com/vision/docs/pricing Pricing
     *
     * @param  resource|string|Object $image An image to configure with the given
     *         settings. This parameter will accept a resource, a string of
     *         bytes, or an instance of {@see Google\Cloud\Storage\Object}.
     * @param  array $features A list of cloud vision
     *         [features](https://cloud.google.com/vision/reference/rest/v1/images/annotate#type)
     *         to apply to the image. gcloud-php provides a set of abbreviated
     *         names which can be used in the interest of brevity in place of
     *         the names offered by the cloud vision service. These names are
     *         `faces`, `landmarks`, `logos`, `labels`, `text`, `safeSearch`
     *         and `properties`.
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
     */
    public function __construct($image, array $features, array $options = [])
    {
        $this->options = $options + [
            'imageContext' => [],
            'maxResults' => []
        ];

        $this->features = $this->normalizeFeatures($features);

        if ($image instanceof Object) {
            $identity = $image->identity();
            $uri = sprintf('gs://%s/%s', $identity['bucket'], $identity['object']);

            $this->type = self::TYPE_STORAGE;
            $this->image = $uri;
        } elseif (is_string($image)) {
            $this->type = self::TYPE_STRING;
            $this->image = $image;
        } else {
            $this->type = self::TYPE_BYTES;
            $this->image = new Stream($image);
        }
    }

    /**
     * Return a formatted annotate image request.
     *
     * This method is used internally by {@see Google\Cloud\Vision\VisionClient}
     * and is not generally intended for use outside of that context.
     *
     * Example:
     * ```
     * $imageResource = fopen(__DIR__ .'/assets/family-photo.jpg', 'r');
     * $image = $vision->image($fileResource, [
     *     'FACE_DETECTION'
     * ]);
     *
     * $requestObj = $image->requestObject();
     * ```
     *
     * @see https://cloud.google.com/vision/reference/rest/v1/images/annotate#annotateimagerequest AnnotateImageRequest
     *
     * @param  bool $encode If set to true, image bytes will be base64-encoded
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
                'gcsImageUri' => $this->image
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
