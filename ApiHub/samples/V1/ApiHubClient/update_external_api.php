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

// [START apihub_v1_generated_ApiHub_UpdateExternalApi_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\ExternalApi;
use Google\Cloud\ApiHub\V1\UpdateExternalApiRequest;
use Google\Protobuf\FieldMask;

/**
 * Update an External API resource in the API hub. The following fields can be
 * updated:
 *
 * * [display_name][google.cloud.apihub.v1.ExternalApi.display_name]
 * * [description][google.cloud.apihub.v1.ExternalApi.description]
 * * [documentation][google.cloud.apihub.v1.ExternalApi.documentation]
 * * [endpoints][google.cloud.apihub.v1.ExternalApi.endpoints]
 * * [paths][google.cloud.apihub.v1.ExternalApi.paths]
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateExternalApiRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $externalApiDisplayName Display name of the external API. Max length is 63 characters
 *                                       (Unicode Code Points).
 */
function update_external_api_sample(string $externalApiDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $externalApi = (new ExternalApi())
        ->setDisplayName($externalApiDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdateExternalApiRequest())
        ->setExternalApi($externalApi)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var ExternalApi $response */
        $response = $apiHubClient->updateExternalApi($request);
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
    $externalApiDisplayName = '[DISPLAY_NAME]';

    update_external_api_sample($externalApiDisplayName);
}
// [END apihub_v1_generated_ApiHub_UpdateExternalApi_sync]
