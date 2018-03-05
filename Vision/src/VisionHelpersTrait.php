<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

use Google\ApiCore\ArrayTrait;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Google\Cloud\Vision\V1\Feature;
use InvalidArgumentException;

/**
 * Provides helper methods for generated Vision clients.
 */
trait VisionHelpersTrait
{
    use ArrayTrait;

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
     * @param callback $callback
     * @param AnnotateImageRequest|mixed $requestClass
     * @param Image|mixed $image
     * @param Feature[]|int[] $features
     * @param array $optionalArgs
     * @return AnnotateImageResponse|mixed
     */
    private function annotateImageHelper(
        $callback,
        $requestClass,
        $image,
        $features,
        $optionalArgs = []
    ) {
        $request = new $requestClass();
        $request->setImage($image);
        $features = $this->buildFeatureList(Feature::class, $features);
        $request->setFeatures($features);
        $imageContext = $this->pluck('imageContext', $optionalArgs, false);
        if (!is_null($imageContext)) {
            $request->setImageContext($imageContext);
        }
        return $callback([$request], $optionalArgs)->getResponses()[0];
    }

    /**
     * @param string $featureClass
     * @param Feature[]|int[] $featureTypes
     * @return Feature[]|array
     */
    private function buildFeatureList($featureClass, $featureTypes)
    {
        $features = [];
        foreach ($featureTypes as $featureType) {
            if (is_int($featureType)) {
                $feature = new $featureClass();
                $feature->setType($featureType);
            } else {
                $feature = $featureType;
            }
            $features[] = $feature;
        }
        return $features;
    }

    /**
     * @param string                      $imageClass
     * @param string                      $imageSourceClass
     * @param string|resource|Image|mixed $imageInput
     * @return Image|mixed
     */
    private function createImageHelper($imageClass, $imageSourceClass, $imageInput)
    {
        if (is_object($imageInput) && is_a($imageInput, $imageClass)) {
            return $imageInput;
        }
        $image = new $imageClass();
        if (is_string($imageInput)) {
            if (in_array(parse_url($imageInput, PHP_URL_SCHEME), $this->urlSchemes)) {
                $imageSource = new $imageSourceClass();
                $imageSource->setImageUri($imageInput);
                $image->setSource($imageSource);
            } else {
                $image->setContent($imageInput);
            }
        } elseif (is_resource($imageInput)) {
            $image->setContent(stream_get_contents($imageInput));
        } else {
            throw new InvalidArgumentException(
                'Given image is not valid. ' .
                'Image must be a string of bytes, a valid image URI, or a resource.'
            );
        }
        return $image;
    }
}
