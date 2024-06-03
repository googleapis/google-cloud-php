<?php
/*
 * Copyright 2024 Google LLC
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

// [START securitycenter_v2_generated_SecurityCenter_UpdateResourceValueConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\ResourceValueConfig;
use Google\Cloud\SecurityCenter\V2\UpdateResourceValueConfigRequest;

/**
 * Updates an existing ResourceValueConfigs with new rules.
 *
 * @param string $resourceValueConfigTagValuesElement Tag values combined with AND to check against.
 *                                                    Values in the form "tagValues/123"
 *                                                    E.g. [ "tagValues/123", "tagValues/456", "tagValues/789" ]
 *                                                    https://cloud.google.com/resource-manager/docs/tags/tags-creating-and-managing
 */
function update_resource_value_config_sample(string $resourceValueConfigTagValuesElement): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $resourceValueConfigTagValues = [$resourceValueConfigTagValuesElement,];
    $resourceValueConfig = (new ResourceValueConfig())
        ->setTagValues($resourceValueConfigTagValues);
    $request = (new UpdateResourceValueConfigRequest())
        ->setResourceValueConfig($resourceValueConfig);

    // Call the API and handle any network failures.
    try {
        /** @var ResourceValueConfig $response */
        $response = $securityCenterClient->updateResourceValueConfig($request);
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
    $resourceValueConfigTagValuesElement = '[TAG_VALUES]';

    update_resource_value_config_sample($resourceValueConfigTagValuesElement);
}
// [END securitycenter_v2_generated_SecurityCenter_UpdateResourceValueConfig_sync]
