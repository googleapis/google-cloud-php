<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_SlateService_BatchUpdateSlates_sync]
use Google\Ads\AdManager\V1\BatchUpdateSlatesRequest;
use Google\Ads\AdManager\V1\BatchUpdateSlatesResponse;
use Google\Ads\AdManager\V1\Client\SlateServiceClient;
use Google\Ads\AdManager\V1\Slate;
use Google\Ads\AdManager\V1\UpdateSlateRequest;
use Google\ApiCore\ApiException;

/**
 * Batch updates `Slate` objects.
 *
 * @param string $formattedParent          The parent resource where `Slates` will be updated.
 *                                         Format: `networks/{network_code}`
 *                                         The parent field in the UpdateSlateRequest must match this
 *                                         field. Please see
 *                                         {@see SlateServiceClient::networkName()} for help formatting this field.
 * @param string $requestsSlateDisplayName The display name of the Slate. It has a maximum length of 255
 *                                         characters.
 */
function batch_update_slates_sample(
    string $formattedParent,
    string $requestsSlateDisplayName
): void {
    // Create a client.
    $slateServiceClient = new SlateServiceClient();

    // Prepare the request message.
    $requestsSlate = (new Slate())
        ->setDisplayName($requestsSlateDisplayName);
    $updateSlateRequest = (new UpdateSlateRequest())
        ->setSlate($requestsSlate);
    $requests = [$updateSlateRequest,];
    $request = (new BatchUpdateSlatesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateSlatesResponse $response */
        $response = $slateServiceClient->batchUpdateSlates($request);
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
    $formattedParent = SlateServiceClient::networkName('[NETWORK_CODE]');
    $requestsSlateDisplayName = '[DISPLAY_NAME]';

    batch_update_slates_sample($formattedParent, $requestsSlateDisplayName);
}
// [END admanager_v1_generated_SlateService_BatchUpdateSlates_sync]
