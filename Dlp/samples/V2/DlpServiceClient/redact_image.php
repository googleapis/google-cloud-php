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

// [START dlp_v2_generated_DlpService_RedactImage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dlp\V2\Client\DlpServiceClient;
use Google\Cloud\Dlp\V2\RedactImageRequest;
use Google\Cloud\Dlp\V2\RedactImageResponse;

/**
 * Redacts potentially sensitive info from an image.
 * This method has limits on input size, processing time, and output size.
 * See
 * https://cloud.google.com/sensitive-data-protection/docs/redacting-sensitive-data-images
 * to learn more.
 *
 * When no InfoTypes or CustomInfoTypes are specified in this request, the
 * system will automatically choose what detectors to run. By default this may
 * be all types, but may change over time as detectors are updated.
 *
 * Only the first frame of each multiframe image is redacted. Metadata and
 * other frames are omitted in the response.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function redact_image_sample(): void
{
    // Create a client.
    $dlpServiceClient = new DlpServiceClient();

    // Prepare the request message.
    $request = new RedactImageRequest();

    // Call the API and handle any network failures.
    try {
        /** @var RedactImageResponse $response */
        $response = $dlpServiceClient->redactImage($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dlp_v2_generated_DlpService_RedactImage_sync]
