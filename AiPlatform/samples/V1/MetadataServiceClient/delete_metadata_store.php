<?php
/*
 * Copyright 2022 Google LLC
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

// [START aiplatform_v1_generated_MetadataService_DeleteMetadataStore_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\MetadataServiceClient;
use Google\Rpc\Status;

/**
 * Deletes a single MetadataStore and all its child resources (Artifacts,
 * Executions, and Contexts).
 *
 * @param string $formattedName The resource name of the MetadataStore to delete.
 *                              Format:
 *                              `projects/{project}/locations/{location}/metadataStores/{metadatastore}`
 *                              Please see {@see MetadataServiceClient::metadataStoreName()} for help formatting this field.
 */
function delete_metadata_store_sample(string $formattedName): void
{
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $metadataServiceClient->deleteMetadataStore($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = MetadataServiceClient::metadataStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[METADATA_STORE]'
    );

    delete_metadata_store_sample($formattedName);
}
// [END aiplatform_v1_generated_MetadataService_DeleteMetadataStore_sync]
