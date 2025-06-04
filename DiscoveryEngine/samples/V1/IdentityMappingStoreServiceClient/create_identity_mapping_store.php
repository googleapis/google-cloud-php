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

// [START discoveryengine_v1_generated_IdentityMappingStoreService_CreateIdentityMappingStore_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\IdentityMappingStoreServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateIdentityMappingStoreRequest;
use Google\Cloud\DiscoveryEngine\V1\IdentityMappingStore;

/**
 * Creates a new Identity Mapping Store.
 *
 * @param string $formattedParent        The parent collection resource name, such as
 *                                       `projects/{project}/locations/{location}`. Please see
 *                                       {@see IdentityMappingStoreServiceClient::locationName()} for help formatting this field.
 * @param string $identityMappingStoreId The ID of the Identity Mapping Store to create.
 *
 *                                       The ID must contain only letters (a-z, A-Z), numbers (0-9), underscores
 *                                       (_), and hyphens (-). The maximum length is 63 characters.
 */
function create_identity_mapping_store_sample(
    string $formattedParent,
    string $identityMappingStoreId
): void {
    // Create a client.
    $identityMappingStoreServiceClient = new IdentityMappingStoreServiceClient();

    // Prepare the request message.
    $identityMappingStore = new IdentityMappingStore();
    $request = (new CreateIdentityMappingStoreRequest())
        ->setParent($formattedParent)
        ->setIdentityMappingStoreId($identityMappingStoreId)
        ->setIdentityMappingStore($identityMappingStore);

    // Call the API and handle any network failures.
    try {
        /** @var IdentityMappingStore $response */
        $response = $identityMappingStoreServiceClient->createIdentityMappingStore($request);
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
    $formattedParent = IdentityMappingStoreServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $identityMappingStoreId = '[IDENTITY_MAPPING_STORE_ID]';

    create_identity_mapping_store_sample($formattedParent, $identityMappingStoreId);
}
// [END discoveryengine_v1_generated_IdentityMappingStoreService_CreateIdentityMappingStore_sync]
