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

// [START oracledatabase_v1_generated_OracleDatabase_StartGoldengateDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\GoldengateDeployment;
use Google\Cloud\OracleDatabase\V1\StartGoldengateDeploymentRequest;
use Google\Rpc\Status;

/**
 * Starts a single GoldengateDeployment.
 *
 * @param string $formattedName The name of the Goldengate Deployment in the following format:
 *                              projects/{project}/locations/{location}/goldengateDeployments/{goldengate_deployment}. Please see
 *                              {@see OracleDatabaseClient::goldengateDeploymentName()} for help formatting this field.
 */
function start_goldengate_deployment_sample(string $formattedName): void
{
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $request = (new StartGoldengateDeploymentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->startGoldengateDeployment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GoldengateDeployment $result */
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
    $formattedName = OracleDatabaseClient::goldengateDeploymentName(
        '[PROJECT]',
        '[LOCATION]',
        '[GOLDENGATE_DEPLOYMENT]'
    );

    start_goldengate_deployment_sample($formattedName);
}
// [END oracledatabase_v1_generated_OracleDatabase_StartGoldengateDeployment_sync]
