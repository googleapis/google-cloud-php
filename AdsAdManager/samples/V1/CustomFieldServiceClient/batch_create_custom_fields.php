<?php
/*
 * Copyright 2025 Google LLC
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

// [START admanager_v1_generated_CustomFieldService_BatchCreateCustomFields_sync]
use Google\Ads\AdManager\V1\BatchCreateCustomFieldsRequest;
use Google\Ads\AdManager\V1\BatchCreateCustomFieldsResponse;
use Google\Ads\AdManager\V1\Client\CustomFieldServiceClient;
use Google\Ads\AdManager\V1\CreateCustomFieldRequest;
use Google\Ads\AdManager\V1\CustomField;
use Google\Ads\AdManager\V1\CustomFieldDataTypeEnum\CustomFieldDataType;
use Google\Ads\AdManager\V1\CustomFieldEntityTypeEnum\CustomFieldEntityType;
use Google\Ads\AdManager\V1\CustomFieldVisibilityEnum\CustomFieldVisibility;
use Google\ApiCore\ApiException;

/**
 * API to batch create `CustomField` objects.
 *
 * @param string $formattedParent                The parent resource where `CustomFields` will be created.
 *                                               Format: `networks/{network_code}`
 *                                               The parent field in the CreateCustomFieldRequest must match this
 *                                               field. Please see
 *                                               {@see CustomFieldServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent        The parent resource where this `CustomField` will be created.
 *                                               Format: `networks/{network_code}`
 *                                               Please see {@see CustomFieldServiceClient::networkName()} for help formatting this field.
 * @param string $requestsCustomFieldDisplayName Name of the CustomField. The max length is 127 characters.
 * @param int    $requestsCustomFieldEntityType  The type of entity the `CustomField` can be applied to.
 * @param int    $requestsCustomFieldDataType    The data type of the `CustomField`.
 * @param int    $requestsCustomFieldVisibility  The visibility of the `CustomField`.
 */
function batch_create_custom_fields_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsCustomFieldDisplayName,
    int $requestsCustomFieldEntityType,
    int $requestsCustomFieldDataType,
    int $requestsCustomFieldVisibility
): void {
    // Create a client.
    $customFieldServiceClient = new CustomFieldServiceClient();

    // Prepare the request message.
    $requestsCustomField = (new CustomField())
        ->setDisplayName($requestsCustomFieldDisplayName)
        ->setEntityType($requestsCustomFieldEntityType)
        ->setDataType($requestsCustomFieldDataType)
        ->setVisibility($requestsCustomFieldVisibility);
    $createCustomFieldRequest = (new CreateCustomFieldRequest())
        ->setParent($formattedRequestsParent)
        ->setCustomField($requestsCustomField);
    $requests = [$createCustomFieldRequest,];
    $request = (new BatchCreateCustomFieldsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateCustomFieldsResponse $response */
        $response = $customFieldServiceClient->batchCreateCustomFields($request);
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
    $formattedParent = CustomFieldServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = CustomFieldServiceClient::networkName('[NETWORK_CODE]');
    $requestsCustomFieldDisplayName = '[DISPLAY_NAME]';
    $requestsCustomFieldEntityType = CustomFieldEntityType::CUSTOM_FIELD_ENTITY_TYPE_UNSPECIFIED;
    $requestsCustomFieldDataType = CustomFieldDataType::CUSTOM_FIELD_DATA_TYPE_UNSPECIFIED;
    $requestsCustomFieldVisibility = CustomFieldVisibility::CUSTOM_FIELD_VISIBILITY_UNSPECIFIED;

    batch_create_custom_fields_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsCustomFieldDisplayName,
        $requestsCustomFieldEntityType,
        $requestsCustomFieldDataType,
        $requestsCustomFieldVisibility
    );
}
// [END admanager_v1_generated_CustomFieldService_BatchCreateCustomFields_sync]
