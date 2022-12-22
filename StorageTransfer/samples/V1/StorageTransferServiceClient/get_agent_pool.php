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

// [START storagetransfer_v1_generated_StorageTransferService_GetAgentPool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\StorageTransfer\V1\AgentPool;
use Google\Cloud\StorageTransfer\V1\StorageTransferServiceClient;

/**
 * Gets an agent pool.
 *
 * @param string $name The name of the agent pool to get.
 */
function get_agent_pool_sample(string $name): void
{
    // Create a client.
    $storageTransferServiceClient = new StorageTransferServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AgentPool $response */
        $response = $storageTransferServiceClient->getAgentPool($name);
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
    $name = '[NAME]';

    get_agent_pool_sample($name);
}
// [END storagetransfer_v1_generated_StorageTransferService_GetAgentPool_sync]
