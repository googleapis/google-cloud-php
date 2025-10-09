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

// [START apihub_v1_generated_ApiHub_UpdateAttribute_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Attribute;
use Google\Cloud\ApiHub\V1\Attribute\DataType;
use Google\Cloud\ApiHub\V1\Attribute\Scope;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\UpdateAttributeRequest;
use Google\Protobuf\FieldMask;

/**
 * Update the attribute.  The following fields in the
 * [Attribute resource][google.cloud.apihub.v1.Attribute] can be updated:
 *
 * * [display_name][google.cloud.apihub.v1.Attribute.display_name]
 * The display name can be updated for user defined attributes only.
 * * [description][google.cloud.apihub.v1.Attribute.description]
 * The description can be updated for user defined attributes only.
 * * [allowed_values][google.cloud.apihub.v1.Attribute.allowed_values]
 * To update the list of allowed values, clients need to use the fetched list
 * of allowed values and add or remove values to or from the same list.
 * The mutable allowed values can be updated for both user defined and System
 * defined attributes. The immutable allowed values cannot be updated or
 * deleted. The updated list of allowed values cannot be empty. If an allowed
 * value that is already used by some resource's attribute is deleted, then
 * the association between the resource and the attribute value will also be
 * deleted.
 * * [cardinality][google.cloud.apihub.v1.Attribute.cardinality]
 * The cardinality can be updated for user defined attributes only.
 * Cardinality can only be increased during an update.
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateAttributeRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $attributeDisplayName The display name of the attribute.
 * @param int    $attributeScope       The scope of the attribute. It represents the resource in the API
 *                                     Hub to which the attribute can be linked.
 * @param int    $attributeDataType    The type of the data of the attribute.
 */
function update_attribute_sample(
    string $attributeDisplayName,
    int $attributeScope,
    int $attributeDataType
): void {
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $attribute = (new Attribute())
        ->setDisplayName($attributeDisplayName)
        ->setScope($attributeScope)
        ->setDataType($attributeDataType);
    $updateMask = new FieldMask();
    $request = (new UpdateAttributeRequest())
        ->setAttribute($attribute)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Attribute $response */
        $response = $apiHubClient->updateAttribute($request);
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
    $attributeDisplayName = '[DISPLAY_NAME]';
    $attributeScope = Scope::SCOPE_UNSPECIFIED;
    $attributeDataType = DataType::DATA_TYPE_UNSPECIFIED;

    update_attribute_sample($attributeDisplayName, $attributeScope, $attributeDataType);
}
// [END apihub_v1_generated_ApiHub_UpdateAttribute_sync]
