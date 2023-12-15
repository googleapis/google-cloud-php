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

// [START dialogflow_v3_generated_Environments_RunContinuousTest_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\EnvironmentsClient;
use Google\Cloud\Dialogflow\Cx\V3\RunContinuousTestResponse;
use Google\Rpc\Status;

/**
 * Kicks off a continuous test under the specified
 * [Environment][google.cloud.dialogflow.cx.v3.Environment].
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [RunContinuousTestMetadata][google.cloud.dialogflow.cx.v3.RunContinuousTestMetadata]
 * - `response`:
 * [RunContinuousTestResponse][google.cloud.dialogflow.cx.v3.RunContinuousTestResponse]
 *
 * @param string $formattedEnvironment Format: `projects/<Project ID>/locations/<Location
 *                                     ID>/agents/<Agent ID>/environments/<Environment ID>`. Please see
 *                                     {@see EnvironmentsClient::environmentName()} for help formatting this field.
 */
function run_continuous_test_sample(string $formattedEnvironment): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $environmentsClient->runContinuousTest($formattedEnvironment);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RunContinuousTestResponse $result */
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
    $formattedEnvironment = EnvironmentsClient::environmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[ENVIRONMENT]'
    );

    run_continuous_test_sample($formattedEnvironment);
}
// [END dialogflow_v3_generated_Environments_RunContinuousTest_sync]
