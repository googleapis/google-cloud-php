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

// [START videostitcher_v1_generated_VideoStitcherService_CreateCdnKey_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\Stitcher\V1\CdnKey;
use Google\Cloud\Video\Stitcher\V1\VideoStitcherServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new CDN key.
 *
 * @param string $formattedParent The project in which the CDN key should be created, in the form
 *                                of `projects/{project_number}/locations/{location}`. Please see
 *                                {@see VideoStitcherServiceClient::locationName()} for help formatting this field.
 * @param string $cdnKeyId        The ID to use for the CDN key, which will become the final
 *                                component of the CDN key's resource name.
 *
 *                                This value should conform to RFC-1034, which restricts to
 *                                lower-case letters, numbers, and hyphen, with the first character a
 *                                letter, the last a letter or a number, and a 63 character maximum.
 */
function create_cdn_key_sample(string $formattedParent, string $cdnKeyId): void
{
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $cdnKey = new CdnKey();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $videoStitcherServiceClient->createCdnKey($formattedParent, $cdnKey, $cdnKeyId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CdnKey $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedParent = VideoStitcherServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $cdnKeyId = '[CDN_KEY_ID]';

    create_cdn_key_sample($formattedParent, $cdnKeyId);
}
// [END videostitcher_v1_generated_VideoStitcherService_CreateCdnKey_sync]
