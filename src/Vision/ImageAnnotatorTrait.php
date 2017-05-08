<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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
use google\cloud\vision\v1\AnnotateImageRequest;
use google\cloud\vision\v1\FaceAnnotation;
use google\cloud\vision\v1\Feature;
use google\cloud\vision\v1\ImageSource;
use google\cloud\vision\v1\Position;
use InvalidArgumentException;

trait ImageAnnotatorTrait
{
    private static $URL_SCHEMES = [
        'http',
        'https',
        'gs',
    ];

    private $client;

    protected function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @param resource|string|StorageObject $image
     * @param \Google\Cloud\Vision\V1\Feature\Type[] $features
     * @param array $optionalArgs {
     *
     *     @type array $maxResults An array of maximum number of features to return
     *     @type \Google\Cloud\Vision\V1\ImageContext $imageContext
     *     @type string $requestClass The request class to use
     *     @type string $featureClass The feature class to use
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     * @return \Google\Cloud\Vision\V1\AnnotateImageResponse The server response
     */
    protected function detectFeaturesImpl($image, $features, $optionalArgs = [])
    {
        $defaultArgs = [
            'maxResults' => [],
            'imageContext' => null,
            'requestClass' => '\google\cloud\vision\v1\AnnotateImageRequest',
            'featureClass' => '\google\cloud\vision\v1\Feature',
        ];
        $optionalArgs = $optionalArgs + $defaultArgs;

        $maxResults = $optionalArgs['maxResults'];
        $imageContext = $optionalArgs['imageContext'];
        $requestClass = $optionalArgs['requestClass'];
        $featureClass = $optionalArgs['featureClass'];

        $annotateImageRequest = new $requestClass();
        $annotateImageRequest->setImage($this->resolveImage($image));

        foreach ($features as $featureType) {
            $feature = new $featureClass();
            $feature->setType($featureType);
            if (isset($maxResults[$featureType])) {
                $feature->setMaxResults($maxResults[$featureType]);
            }
            $annotateImageRequest->addFeatures($feature);
        }
        if (isset($imageContext)) {
            $annotateImageRequest->setImageContext($imageContext);
        }

        $optionalArgs = array_diff_key($optionalArgs, $defaultArgs);
        $batchResponse = $this->client->batchAnnotateImages([$annotateImageRequest], $optionalArgs);
        return $batchResponse->getResponses(0);
    }

    /**
     * @param resource|string|StorageObject $image
     * @param \Google\Cloud\Vision\V1\Feature\Type|int $featureType
     * @param string $getFeatureMethod
     * @param array $optionalArgs {
     *
     *     @type integer $maxResults A maximum number of features to return
     *     @type \Google\Cloud\Vision\V1\ImageContext $imageContext
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     * @return FaceAnnotation[] Array of face annotations
     */
    protected function detectFeatureTypeImpl($image, $featureType, $getFeatureMethod, $optionalArgs = [])
    {
        $maxResults = [];
        if (isset($optionalArgs['maxResults'])) {
            $maxResults[$featureType] = $optionalArgs['maxResults'];
        }
        $optionalArgs['maxResults'] = $maxResults;
        $response = $this->detectFeatures($image, [$featureType], $optionalArgs);
        return $response->$getFeatureMethod();
    }

    /**
     * @param FaceAnnotation $faceAnnotation
     * @param FaceAnnotation\Landmark\Type|int $landmarkType
     * @return Position|null Landmark position
     */
    protected function getFaceLandmarkPositionImpl($faceAnnotation, $landmarkType)
    {
        foreach($faceAnnotation->getLandmarksList() as $landmark) {
            if ($landmark->getType() === $landmarkType) {
                return $landmark->getPosition();
            }
        }
        return null;
    }

    /**
     * @param resource|string|StorageObject $imageInput
     * @param \google\cloud\vision\v1\Image $imageObj
     * @param \google\cloud\vision\v1\ImageSource $imageSource
     * @return \google\cloud\vision\v1\Image
     */
    protected function resolveImage($imageInput, $imageObj = null, $imageSource = null)
    {
        if (is_null($imageObj)) {
            $imageObj = new \google\cloud\vision\v1\Image();
        }
        if (is_null($imageSource)) {
            $imageSource = new ImageSource();
        }
        if (is_string($imageInput) && in_array(parse_url($imageInput, PHP_URL_SCHEME), self::$URL_SCHEMES)) {
            $imageSource->setImageUri($imageInput);
            $imageObj->setSource($imageSource);
        } elseif (is_string($imageInput)) {
            $imageObj->setContent($imageInput);
        } elseif ($imageInput instanceof StorageObject) {
            $imageSource->setImageUri($imageInput->gcsUri());
            $imageObj->setSource($imageSource);
        } elseif (is_resource($imageInput)) {
            $imageObj->setContent(stream_get_contents($imageInput));
        } else {
            throw new InvalidArgumentException(
                'Given image is not valid. Image must be a string of bytes, ' .
                'a google storage object, a valid image URI, or a resource.'
            );
        }
        return $imageObj;
    }
}

