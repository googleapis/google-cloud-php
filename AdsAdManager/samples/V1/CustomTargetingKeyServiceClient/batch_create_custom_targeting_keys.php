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

// [START admanager_v1_generated_CustomTargetingKeyService_BatchCreateCustomTargetingKeys_sync]
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingKeysRequest;
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingKeysResponse;
use Google\Ads\AdManager\V1\Client\CustomTargetingKeyServiceClient;
use Google\Ads\AdManager\V1\CreateCustomTargetingKeyRequest;
use Google\Ads\AdManager\V1\CustomTargetingKey;
use Google\Ads\AdManager\V1\CustomTargetingKeyReportableTypeEnum\CustomTargetingKeyReportableType;
use Google\Ads\AdManager\V1\CustomTargetingKeyTypeEnum\CustomTargetingKeyType;
use Google\ApiCore\ApiException;

/**
 * API to batch create `CustomTargetingKey` objects.
 *
 * @param string $formattedParent                          The parent resource where `CustomTargetingKeys` will be created.
 *                                                         Format: `networks/{network_code}`
 *                                                         The parent field in the CreateCustomTargetingKeyRequest must match this
 *                                                         field. Please see
 *                                                         {@see CustomTargetingKeyServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                  The parent resource where this `CustomTargetingKey` will be
 *                                                         created. Format: `networks/{network_code}`
 *                                                         Please see {@see CustomTargetingKeyServiceClient::networkName()} for help formatting this field.
 * @param int    $requestsCustomTargetingKeyType           Indicates whether users will select from predefined values or
 *                                                         create new targeting values, while specifying targeting criteria for a line
 *                                                         item.
 * @param int    $requestsCustomTargetingKeyReportableType Reportable state of the `CustomTargetingKey`.
 */
function batch_create_custom_targeting_keys_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    int $requestsCustomTargetingKeyType,
    int $requestsCustomTargetingKeyReportableType
): void {
    // Create a client.
    $customTargetingKeyServiceClient = new CustomTargetingKeyServiceClient();

    // Prepare the request message.
    $requestsCustomTargetingKey = (new CustomTargetingKey())
        ->setType($requestsCustomTargetingKeyType)
        ->setReportableType($requestsCustomTargetingKeyReportableType);
    $createCustomTargetingKeyRequest = (new CreateCustomTargetingKeyRequest())
        ->setParent($formattedRequestsParent)
        ->setCustomTargetingKey($requestsCustomTargetingKey);
    $requests = [$createCustomTargetingKeyRequest,];
    $request = (new BatchCreateCustomTargetingKeysRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateCustomTargetingKeysResponse $response */
        $response = $customTargetingKeyServiceClient->batchCreateCustomTargetingKeys($request);
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
    $formattedParent = CustomTargetingKeyServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = CustomTargetingKeyServiceClient::networkName('[NETWORK_CODE]');
    $requestsCustomTargetingKeyType = CustomTargetingKeyType::CUSTOM_TARGETING_KEY_TYPE_UNSPECIFIED;
    $requestsCustomTargetingKeyReportableType = CustomTargetingKeyReportableType::CUSTOM_TARGETING_KEY_REPORTABLE_TYPE_UNSPECIFIED;

    batch_create_custom_targeting_keys_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsCustomTargetingKeyType,
        $requestsCustomTargetingKeyReportableType
    );
}
// [END admanager_v1_generated_CustomTargetingKeyService_BatchCreateCustomTargetingKeys_sync]
