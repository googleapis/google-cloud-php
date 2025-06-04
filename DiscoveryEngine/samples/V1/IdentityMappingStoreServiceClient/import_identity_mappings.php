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

// [START discoveryengine_v1_generated_IdentityMappingStoreService_ImportIdentityMappings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\IdentityMappingStoreServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ImportIdentityMappingsRequest;
use Google\Cloud\DiscoveryEngine\V1\ImportIdentityMappingsResponse;
use Google\Rpc\Status;

/**
 * Imports a list of Identity Mapping Entries to an Identity Mapping Store.
 *
 * @param string $formattedIdentityMappingStore The name of the Identity Mapping Store to import Identity Mapping
 *                                              Entries to. Format:
 *                                              `projects/{project}/locations/{location}/identityMappingStores/{identityMappingStore}`
 *                                              Please see {@see IdentityMappingStoreServiceClient::identityMappingStoreName()} for help formatting this field.
 */
function import_identity_mappings_sample(string $formattedIdentityMappingStore): void
{
    // Create a client.
    $identityMappingStoreServiceClient = new IdentityMappingStoreServiceClient();

    // Prepare the request message.
    $request = (new ImportIdentityMappingsRequest())
        ->setIdentityMappingStore($formattedIdentityMappingStore);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $identityMappingStoreServiceClient->importIdentityMappings($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportIdentityMappingsResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedIdentityMappingStore = IdentityMappingStoreServiceClient::identityMappingStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[IDENTITY_MAPPING_STORE]'
    );

    import_identity_mappings_sample($formattedIdentityMappingStore);
}
// [END discoveryengine_v1_generated_IdentityMappingStoreService_ImportIdentityMappings_sync]
