<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Vision\V1;

use Google\Cloud\Vision\ImageAnnotatorTrait;

class ImageAnnotatorClient extends ImageAnnotatorGapicClient
{
    use ImageAnnotatorTrait;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->setClient($this);
    }

    /**
     * @param resource|string|Image $image
     * @param \Google\Cloud\Vision\V1\Feature\Type[]|int $features
     * @param array $optionalArgs {
     *
     *     @type array $maxResults An array of maximum number of features to return
     *     @type \Google\Cloud\Vision\V1\ImageContext $imageContext
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     * @return \Google\Cloud\Vision\V1\AnnotateImageResponse The server response
     */
    public function annotateImage($image, $features, $optionalArgs = [])
    {
        return $this->annotateImageImpl($image, $features, $optionalArgs);
    }

    /**
     * @param resource|string|Image $image
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
    public function annotateFaces($image, $optionalArgs = [])
    {
        return $this->annotateFeatureTypeImpl(
            $image,
            Feature\Type::FACE_DETECTION,
            'getFaceAnnotationsList',
            $optionalArgs
        );
    }

    /**
     * @param FaceAnnotation $faceAnnotation
     * @param FaceAnnotation\Landmark\Type|int $landmarkType
     * @return Position|null Landmark position
     */
    public function getFaceLandmarkPosition($faceAnnotation, $landmarkType)
    {
        return $this->getFaceLandmarkPositionImpl($faceAnnotation, $landmarkType);
    }
}
