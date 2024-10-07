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

// [START apihub_v1_generated_ApiHub_UpdateApi_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Api;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\UpdateApiRequest;
use Google\Protobuf\FieldMask;

/**
 * Update an API resource in the API hub. The following fields in the
 * [API][] can be updated:
 *
 * * [display_name][google.cloud.apihub.v1.Api.display_name]
 * * [description][google.cloud.apihub.v1.Api.description]
 * * [owner][google.cloud.apihub.v1.Api.owner]
 * * [documentation][google.cloud.apihub.v1.Api.documentation]
 * * [target_user][google.cloud.apihub.v1.Api.target_user]
 * * [team][google.cloud.apihub.v1.Api.team]
 * * [business_unit][google.cloud.apihub.v1.Api.business_unit]
 * * [maturity_level][google.cloud.apihub.v1.Api.maturity_level]
 * * [attributes][google.cloud.apihub.v1.Api.attributes]
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateApiRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * Updating the owner field requires complete owner message
 * and updates both owner and email fields.
 *
 * @param string $apiDisplayName The display name of the API resource.
 */
function update_api_sample(string $apiDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $api = (new Api())
        ->setDisplayName($apiDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdateApiRequest())
        ->setApi($api)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Api $response */
        $response = $apiHubClient->updateApi($request);
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
    $apiDisplayName = '[DISPLAY_NAME]';

    update_api_sample($apiDisplayName);
}
// [END apihub_v1_generated_ApiHub_UpdateApi_sync]
