<?php
/*
 * Copyright 2022 Google LLC
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
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START vision_v1_generated_ProductSearch_CreateReferenceImage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Cloud\Vision\V1\ReferenceImage;

/**
 * Creates and returns a new ReferenceImage resource.
 *
 * The `bounding_poly` field is optional. If `bounding_poly` is not specified,
 * the system will try to detect regions of interest in the image that are
 * compatible with the product_category on the parent product. If it is
 * specified, detection is ALWAYS skipped. The system converts polygons into
 * non-rotated rectangles.
 *
 * Note that the pipeline will resize the image if the image resolution is too
 * large to process (above 50MP).
 *
 * Possible errors:
 *
 * * Returns INVALID_ARGUMENT if the image_uri is missing or longer than 4096
 * characters.
 * * Returns INVALID_ARGUMENT if the product does not exist.
 * * Returns INVALID_ARGUMENT if bounding_poly is not provided, and nothing
 * compatible with the parent product's product_category is detected.
 * * Returns INVALID_ARGUMENT if bounding_poly contains more than 10 polygons.
 *
 * @param string $formattedParent   Resource name of the product in which to create the reference image.
 *
 *                                  Format is
 *                                  `projects/PROJECT_ID/locations/LOC_ID/products/PRODUCT_ID`. Please see
 *                                  {@see ProductSearchClient::productName()} for help formatting this field.
 * @param string $referenceImageUri The Google Cloud Storage URI of the reference image.
 *
 *                                  The URI must start with `gs://`.
 */
function create_reference_image_sample(string $formattedParent, string $referenceImageUri): void
{
    // Create a client.
    $productSearchClient = new ProductSearchClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $referenceImage = (new ReferenceImage())
        ->setUri($referenceImageUri);

    // Call the API and handle any network failures.
    try {
        /** @var ReferenceImage $response */
        $response = $productSearchClient->createReferenceImage($formattedParent, $referenceImage);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = ProductSearchClient::productName('[PROJECT]', '[LOCATION]', '[PRODUCT]');
    $referenceImageUri = '[URI]';

    create_reference_image_sample($formattedParent, $referenceImageUri);
}
// [END vision_v1_generated_ProductSearch_CreateReferenceImage_sync]
