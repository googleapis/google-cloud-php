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

// [START vision_v1_generated_ImageAnnotator_BatchAnnotateImages_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesResponse;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

/**
 * Run image detection and annotation for a batch of images.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function batch_annotate_images_sample(): void
{
    // Create a client.
    $imageAnnotatorClient = new ImageAnnotatorClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requests = [new AnnotateImageRequest()];

    // Call the API and handle any network failures.
    try {
        /** @var BatchAnnotateImagesResponse $response */
        $response = $imageAnnotatorClient->batchAnnotateImages($requests);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END vision_v1_generated_ImageAnnotator_BatchAnnotateImages_sync]
