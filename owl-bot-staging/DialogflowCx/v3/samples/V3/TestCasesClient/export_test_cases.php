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

// [START dialogflow_v3_generated_TestCases_ExportTestCases_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\TestCasesClient;
use Google\Cloud\Dialogflow\Cx\V3\ExportTestCasesRequest;
use Google\Cloud\Dialogflow\Cx\V3\ExportTestCasesResponse;
use Google\Rpc\Status;

/**
 * Exports the test cases under the agent to a Cloud Storage bucket or a local
 * file. Filter can be applied to export a subset of test cases.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [ExportTestCasesMetadata][google.cloud.dialogflow.cx.v3.ExportTestCasesMetadata]
 * - `response`:
 * [ExportTestCasesResponse][google.cloud.dialogflow.cx.v3.ExportTestCasesResponse]
 *
 * @param string $formattedParent The agent where to export test cases from.
 *                                Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>`. Please see
 *                                {@see TestCasesClient::agentName()} for help formatting this field.
 */
function export_test_cases_sample(string $formattedParent): void
{
    // Create a client.
    $testCasesClient = new TestCasesClient();

    // Prepare the request message.
    $request = (new ExportTestCasesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $testCasesClient->exportTestCases($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportTestCasesResponse $result */
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
    $formattedParent = TestCasesClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');

    export_test_cases_sample($formattedParent);
}
// [END dialogflow_v3_generated_TestCases_ExportTestCases_sync]
