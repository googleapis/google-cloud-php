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

// [START apihub_v1_generated_ApiHub_CreateAttribute_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Attribute;
use Google\Cloud\ApiHub\V1\Attribute\DataType;
use Google\Cloud\ApiHub\V1\Attribute\Scope;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\CreateAttributeRequest;

/**
 * Create a user defined attribute.
 *
 * Certain pre defined attributes are already created by the API hub. These
 * attributes will have type as `SYSTEM_DEFINED` and can be listed via
 * [ListAttributes][google.cloud.apihub.v1.ApiHub.ListAttributes] method.
 * Allowed values for the same can be updated via
 * [UpdateAttribute][google.cloud.apihub.v1.ApiHub.UpdateAttribute] method.
 *
 * @param string $formattedParent      The parent resource for Attribute.
 *                                     Format: `projects/{project}/locations/{location}`
 *                                     Please see {@see ApiHubClient::locationName()} for help formatting this field.
 * @param string $attributeDisplayName The display name of the attribute.
 * @param int    $attributeScope       The scope of the attribute. It represents the resource in the API
 *                                     Hub to which the attribute can be linked.
 * @param int    $attributeDataType    The type of the data of the attribute.
 */
function create_attribute_sample(
    string $formattedParent,
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
    $request = (new CreateAttributeRequest())
        ->setParent($formattedParent)
        ->setAttribute($attribute);

    // Call the API and handle any network failures.
    try {
        /** @var Attribute $response */
        $response = $apiHubClient->createAttribute($request);
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
    $formattedParent = ApiHubClient::locationName('[PROJECT]', '[LOCATION]');
    $attributeDisplayName = '[DISPLAY_NAME]';
    $attributeScope = Scope::SCOPE_UNSPECIFIED;
    $attributeDataType = DataType::DATA_TYPE_UNSPECIFIED;

    create_attribute_sample(
        $formattedParent,
        $attributeDisplayName,
        $attributeScope,
        $attributeDataType
    );
}
// [END apihub_v1_generated_ApiHub_CreateAttribute_sync]
