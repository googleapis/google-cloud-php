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

// [START alloydb_v1beta_generated_AlloyDBAdmin_BatchCreateInstances_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AlloyDb\V1beta\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1beta\BatchCreateInstancesResponse;
use Google\Rpc\Status;

/**
 * Creates new instances under the given project, location and cluster.
 * There can be only one primary instance in a cluster. If the primary
 * instance exists in the cluster as well as this request, then API will
 * throw an error.
 * The primary instance should exist before any read pool instance is
 * created. If the primary instance is a part of the request payload, then
 * the API will take care of creating instances in the correct order.
 * This method is here to support Google-internal use cases, and is not meant
 * for external customers to consume. Please do not start relying on it; its
 * behavior is subject to change without notice.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function batch_create_instances_sample(): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alloyDBAdminClient->batchCreateInstances();
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchCreateInstancesResponse $result */
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
// [END alloydb_v1beta_generated_AlloyDBAdmin_BatchCreateInstances_sync]
