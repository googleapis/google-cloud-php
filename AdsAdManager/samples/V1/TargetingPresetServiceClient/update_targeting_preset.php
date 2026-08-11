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

// [START admanager_v1_generated_TargetingPresetService_UpdateTargetingPreset_sync]
use Google\Ads\AdManager\V1\Client\TargetingPresetServiceClient;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\TargetingPreset;
use Google\Ads\AdManager\V1\UpdateTargetingPresetRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `TargetingPreset` object.
 *
 * @param string $targetingPresetDisplayName The name of the TargetingPreset. This attribute has a maximum
 *                                           length of 255 characters.
 */
function update_targeting_preset_sample(string $targetingPresetDisplayName): void
{
    // Create a client.
    $targetingPresetServiceClient = new TargetingPresetServiceClient();

    // Prepare the request message.
    $targetingPresetTargeting = new Targeting();
    $targetingPreset = (new TargetingPreset())
        ->setDisplayName($targetingPresetDisplayName)
        ->setTargeting($targetingPresetTargeting);
    $request = (new UpdateTargetingPresetRequest())
        ->setTargetingPreset($targetingPreset);

    // Call the API and handle any network failures.
    try {
        /** @var TargetingPreset $response */
        $response = $targetingPresetServiceClient->updateTargetingPreset($request);
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
    $targetingPresetDisplayName = '[DISPLAY_NAME]';

    update_targeting_preset_sample($targetingPresetDisplayName);
}
// [END admanager_v1_generated_TargetingPresetService_UpdateTargetingPreset_sync]
