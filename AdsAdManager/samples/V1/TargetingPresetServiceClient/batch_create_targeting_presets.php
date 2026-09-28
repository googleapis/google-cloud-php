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

// [START admanager_v1_generated_TargetingPresetService_BatchCreateTargetingPresets_sync]
use Google\Ads\AdManager\V1\BatchCreateTargetingPresetsRequest;
use Google\Ads\AdManager\V1\BatchCreateTargetingPresetsResponse;
use Google\Ads\AdManager\V1\Client\TargetingPresetServiceClient;
use Google\Ads\AdManager\V1\CreateTargetingPresetRequest;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\TargetingPreset;
use Google\ApiCore\ApiException;

/**
 * Creates `TargetingPreset` objects.
 *
 * @param string $formattedParent                    The parent resource where `TargetingPresets` will be created.
 *                                                   Format: `networks/{network_code}`
 *                                                   The parent field in the CreateTargetingPresetRequest must match this
 *                                                   field. Please see
 *                                                   {@see TargetingPresetServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent            The parent resource where this `TargetingPreset` will be created.
 *                                                   Format: `networks/{network_code}`
 *                                                   Please see {@see TargetingPresetServiceClient::networkName()} for help formatting this field.
 * @param string $requestsTargetingPresetDisplayName The name of the TargetingPreset. This attribute has a maximum
 *                                                   length of 255 characters.
 */
function batch_create_targeting_presets_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsTargetingPresetDisplayName
): void {
    // Create a client.
    $targetingPresetServiceClient = new TargetingPresetServiceClient();

    // Prepare the request message.
    $requestsTargetingPresetTargeting = new Targeting();
    $requestsTargetingPreset = (new TargetingPreset())
        ->setDisplayName($requestsTargetingPresetDisplayName)
        ->setTargeting($requestsTargetingPresetTargeting);
    $createTargetingPresetRequest = (new CreateTargetingPresetRequest())
        ->setParent($formattedRequestsParent)
        ->setTargetingPreset($requestsTargetingPreset);
    $requests = [$createTargetingPresetRequest,];
    $request = (new BatchCreateTargetingPresetsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateTargetingPresetsResponse $response */
        $response = $targetingPresetServiceClient->batchCreateTargetingPresets($request);
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
    $formattedParent = TargetingPresetServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = TargetingPresetServiceClient::networkName('[NETWORK_CODE]');
    $requestsTargetingPresetDisplayName = '[DISPLAY_NAME]';

    batch_create_targeting_presets_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsTargetingPresetDisplayName
    );
}
// [END admanager_v1_generated_TargetingPresetService_BatchCreateTargetingPresets_sync]
