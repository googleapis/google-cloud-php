<?php
/*
 * Copyright 2023 Google LLC
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

// [START alloydb_v1_generated_AlloyDBAdmin_FailoverInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AlloyDb\V1\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\Instance;
use Google\Rpc\Status;

/**
 * Forces a Failover for a highly available instance.
 * Failover promotes the HA standby instance as the new primary.
 * Imperative only.
 *
 * @param string $formattedName The name of the resource. For the required format, see the
 *                              comment on the Instance.name field. Please see
 *                              {@see AlloyDBAdminClient::instanceName()} for help formatting this field.
 */
function failover_instance_sample(string $formattedName): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alloyDBAdminClient->failoverInstance($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedName = AlloyDBAdminClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[INSTANCE]'
    );

    failover_instance_sample($formattedName);
}
// [END alloydb_v1_generated_AlloyDBAdmin_FailoverInstance_sync]
