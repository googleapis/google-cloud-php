<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/vision/v1/image_annotator.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Vision\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\RetrySettings;
use Google\Cloud\Vision\SingleFeatureMethodTrait;
use Google\Cloud\Vision\V1\Gapic\ImageAnnotatorGapicClient;

/**
 * {@inheritdoc}
 */
class ImageAnnotatorClient extends ImageAnnotatorGapicClient
{
    use SingleFeatureMethodTrait;

    /**
     * Run image detection and annotation for an image.
     *
     * Sample code:
     * ```
     * $imageAnnotatorClient = new ImageAnnotatorClient();
     * try {
     *     $imageContent = file_get_contents('path/to/image.jpg');
     *     $image = new Image();
     *     $image->setContent($imageContent);
     *     $feature = new Feature();
     *     $feature->setType(Feature_Type::FACE_DETECTION);
     *     $features = [$feature];
     *     $request = new AnnotateImageRequest();
     *     $request->setImage($image);
     *     $request->setFeatures($features);
     *     $response = $imageAnnotatorClient->annotateImage($request);
     * } finally {
     *     $imageAnnotatorClient->close();
     * }
     * ```
     *
     * @param AnnotateImageRequest $request      An image annotation request.
     * @param array                $optionalArgs {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function annotateImage($request, $optionalArgs = [])
    {
        return $this->batchAnnotateImages([$request], $optionalArgs)->getResponses()[0];
    }

    /**
     * Run face detection for an image.
     *
     * Sample code:
     * ```
     * $imageAnnotatorClient = new ImageAnnotatorClient();
     * try {
     *     $imageContent = file_get_contents('path/to/image.jpg');
     *     $image = new Image();
     *     $image->setContent($imageContent);
     *     $response = $imageAnnotatorClient->faceDetection($image);
     * } finally {
     *     $imageAnnotatorClient->close();
     * }
     * ```
     *
     * @param Image $image        An image annotation request.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function faceDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Feature_Type::FACE_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run landmark detection for an image.
     *
     * Sample code:
     * ```
     * $imageAnnotatorClient = new ImageAnnotatorClient();
     * try {
     *     $imageContent = file_get_contents('path/to/image.jpg');
     *     $image = new Image();
     *     $image->setContent($imageContent);
     *     $response = $imageAnnotatorClient->landmarkDetection($image);
     * } finally {
     *     $imageAnnotatorClient->close();
     * }
     * ```
     *
     * @param Image $image        An image annotation request.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function landmarkDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Feature_Type::LANDMARK_DETECTION,
            $optionalArgs
        );
    }

    private function annotateSingleFeature($image, $featureType, $optionalArgs)
    {
        $request = $this->buildSingleFeatureRequest(
            AnnotateImageRequest::class,
            Feature::class,
            $image,
            $featureType
        );
        return $this->annotateImage($request, $optionalArgs);
    }
}
