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

// [START datafusion_v1_generated_DataFusion_RestartInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DataFusion\V1\DataFusionClient;
use Google\Cloud\DataFusion\V1\Instance;
use Google\Rpc\Status;

/**
 * Restart a single Data Fusion instance.
 * At the end of an operation instance is fully restarted.
 *
 * @param string $formattedName Name of the Data Fusion instance which need to be restarted in the form of
 *                              projects/{project}/locations/{location}/instances/{instance}
 *                              Please see {@see DataFusionClient::instanceName()} for help formatting this field.
 */
function restart_instance_sample(string $formattedName): void
{
    // Create a client.
    $dataFusionClient = new DataFusionClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataFusionClient->restartInstance($formattedName);
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
    $formattedName = DataFusionClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    restart_instance_sample($formattedName);
}
// [END datafusion_v1_generated_DataFusion_RestartInstance_sync]
