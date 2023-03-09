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
 */

namespace Google\Cloud\Vision\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\ArrayTrait;
use Google\ApiCore\RetrySettings;
use Google\Cloud\Vision\VisionHelpersTrait;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Gapic\ImageAnnotatorGapicClient;
use InvalidArgumentException;

/**
 * {@inheritdoc}
 */
class ImageAnnotatorClient extends ImageAnnotatorGapicClient
{
    use VisionHelpersTrait;

    /**
     * Creates an Image object that can be used as part of an image annotation request.
     *
     * Example:
     * ```
     * //[snippet=resource]
     * $imageResource = fopen('path/to/image.jpg', 'r');
     * $image = $imageAnnotatorClient->createImageObject($imageResource);
     * $response = $imageAnnotatorClient->faceDetection($image);
     * ```
     *
     * ```
     * //[snippet=data]
     * $imageData = file_get_contents('path/to/image.jpg');
     * $image = $imageAnnotatorClient->createImageObject($imageData);
     * $response = $imageAnnotatorClient->faceDetection($image);
     * ```
     *
     * ```
     * //[snippet=url]
     * $imageUri = "gs://my-bucket/image.jpg";
     * $image = $imageAnnotatorClient->createImageObject($imageUri);
     * $response = $imageAnnotatorClient->faceDetection($image);
     * ```
     *
     * @param  resource|string $imageInput An image to configure with
     *         the given settings. This parameter will accept a resource, a
     *         string of bytes, or the URI of an image in a publicly-accessible
     *         web location.
     * @return Image
     * @throws InvalidArgumentException
     */
    public function createImageObject($imageInput)
    {
        return $this->createImageHelper(Image::class, ImageSource::class, $imageInput);
    }

    /**
     * Run image detection and annotation for an image.
     *
     * Example:
     * ```
     * use Google\Cloud\Vision\V1\Feature;
     * use Google\Cloud\Vision\V1\Feature\Type;
     *
     * $imageResource = fopen('path/to/image.jpg', 'r');
     * $features = [Type::FACE_DETECTION];
     * $response = $imageAnnotatorClient->annotateImage($imageResource, $features);
     * ```
     *
     * @param resource|string|Image $image        The image to be processed.
     * @param Feature[]|int[]       $features     Requested features.
     * @param array                 $optionalArgs {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function annotateImage($image, $features, $optionalArgs = [])
    {
        $image = $this->createImageObject($image);
        return $this->annotateImageHelper(
            [$this, 'batchAnnotateImages'],
            AnnotateImageRequest::class,
            $image,
            $features,
            $optionalArgs
        );
    }

    /**
     * Run face detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->faceDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function faceDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::FACE_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run landmark detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->landmarkDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function landmarkDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::LANDMARK_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run logo detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->logoDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function logoDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::LOGO_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run label detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->labelDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function labelDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::LABEL_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run text detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->textDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function textDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::TEXT_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run document text detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->documentTextDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function documentTextDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::DOCUMENT_TEXT_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run safe search detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->safeSearchDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function safeSearchDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::SAFE_SEARCH_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run image properties detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->imagePropertiesDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function imagePropertiesDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::IMAGE_PROPERTIES,
            $optionalArgs
        );
    }

    /**
     * Run crop hints detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->cropHintsDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function cropHintsDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::CROP_HINTS,
            $optionalArgs
        );
    }

    /**
     * Run web detection for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->webDetection($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function webDetection($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::WEB_DETECTION,
            $optionalArgs
        );
    }

    /**
     * Run object localization for an image.
     *
     * Example:
     * ```
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $response = $imageAnnotatorClient->objectLocalization($imageContent);
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function objectLocalization($image, $optionalArgs = [])
    {
        return $this->annotateSingleFeature(
            $image,
            Type::OBJECT_LOCALIZATION,
            $optionalArgs
        );
    }

    /**
     * Run product search for an image.
     *
     * Example:
     * ```
     * use Google\Cloud\Vision\V1\ProductSearchClient;
     * use Google\Cloud\Vision\V1\ProductSearchParams;
     *
     * $imageContent = file_get_contents('path/to/image.jpg');
     * $productSetName = ProductSearchClient::productSetName('PROJECT_ID', 'LOC_ID', 'PRODUCT_SET_ID');
     * $productSearchParams = (new ProductSearchParams)
     *     ->setProductSet($productSetName);
     * $response = $imageAnnotatorClient->productSearch(
     *     $imageContent,
     *     $productSearchParams
     * );
     * ```
     *
     * @param resource|string|Image $image The image to be processed.
     * @param ProductSearchParams   $productSearchParams Parameters for a product search request. Please note, this
     *                              value will override the {@see ProductSearchParams} in the
     *                              {@see ImageContext} instance if provided.
     * @param array $optionalArgs   {
     *     Configuration Options.
     *
     *     @type ImageContext        $imageContext  Additional context that may accompany the image.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see RetrySettings} for example usage.
     * }
     *
     * @return AnnotateImageResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function productSearch($image, ProductSearchParams $productSearchParams, $optionalArgs = [])
    {
        if (isset($optionalArgs['imageContext']) && $optionalArgs['imageContext'] instanceof ImageContext) {
            $optionalArgs['imageContext']->setProductSearchParams($productSearchParams);
        } else {
            $optionalArgs['imageContext'] = (new ImageContext)
                ->setProductSearchParams($productSearchParams);
        }

        return $this->annotateSingleFeature(
            $image,
            Type::PRODUCT_SEARCH,
            $optionalArgs
        );
    }

    /**
     * @param Image $image
     * @param Feature|int $featureType
     * @param array $optionalArgs
     * @return AnnotateImageResponse
     */
    private function annotateSingleFeature($image, $featureType, $optionalArgs)
    {
        return $this->annotateImage($image, [$featureType], $optionalArgs);
    }
}
