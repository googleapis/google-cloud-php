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

// [START apihub_v1_generated_ApiHub_UpdateSpec_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\AttributeValues;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\Spec;
use Google\Cloud\ApiHub\V1\UpdateSpecRequest;
use Google\Protobuf\FieldMask;

/**
 * Update spec. The following fields in the
 * [spec][google.cloud.apihub.v1.Spec] can be updated:
 *
 * * [display_name][google.cloud.apihub.v1.Spec.display_name]
 * * [source_uri][google.cloud.apihub.v1.Spec.source_uri]
 * * [lint_response][google.cloud.apihub.v1.Spec.lint_response]
 * * [attributes][google.cloud.apihub.v1.Spec.attributes]
 * * [contents][google.cloud.apihub.v1.Spec.contents]
 * * [spec_type][google.cloud.apihub.v1.Spec.spec_type]
 *
 * In case of an OAS spec, updating spec contents can lead to:
 * 1. Creation, deletion and update of operations.
 * 2. Creation, deletion and update of definitions.
 * 3. Update of other info parsed out from the new spec.
 *
 * In case of contents or source_uri being present in update mask, spec_type
 * must also be present. Also, spec_type can not be present in update mask if
 * contents or source_uri is not present.
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateSpecRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $specDisplayName The display name of the spec.
 *                                This can contain the file name of the spec.
 */
function update_spec_sample(string $specDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $specSpecType = new AttributeValues();
    $spec = (new Spec())
        ->setDisplayName($specDisplayName)
        ->setSpecType($specSpecType);
    $updateMask = new FieldMask();
    $request = (new UpdateSpecRequest())
        ->setSpec($spec)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Spec $response */
        $response = $apiHubClient->updateSpec($request);
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
    $specDisplayName = '[DISPLAY_NAME]';

    update_spec_sample($specDisplayName);
}
// [END apihub_v1_generated_ApiHub_UpdateSpec_sync]
