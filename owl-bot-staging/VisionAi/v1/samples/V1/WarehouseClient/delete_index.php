<?php
/*
 * Copyright 2026 Google LLC
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

// [START visionai_v1_generated_Warehouse_DeleteIndex_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\WarehouseClient;
use Google\Rpc\Status;

/**
 * Delete a single Index. In order to delete an index, the caller must
 * make sure that it is not deployed to any index endpoint.
 *
 * @param string $formattedName The name of the index to delete.
 *                              Format:
 *                              `projects/{project_number}/locations/{location}/corpora/{corpus}/indexes/{index}`
 *                              Please see {@see WarehouseClient::indexName()} for help formatting this field.
 */
function delete_index_sample(string $formattedName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $warehouseClient->deleteIndex($formattedName);
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
    $formattedName = WarehouseClient::indexName(
        '[PROJECT_NUMBER]',
        '[LOCATION]',
        '[CORPUS]',
        '[INDEX]'
    );

    delete_index_sample($formattedName);
}
// [END visionai_v1_generated_Warehouse_DeleteIndex_sync]
