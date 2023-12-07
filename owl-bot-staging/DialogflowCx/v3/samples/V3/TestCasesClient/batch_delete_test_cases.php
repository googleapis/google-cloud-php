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

// [START dialogflow_v3_generated_TestCases_BatchDeleteTestCases_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\TestCasesClient;

/**
 * Batch deletes test cases.
 *
 * @param string $formattedParent       The agent to delete test cases from.
 *                                      Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>`. Please see
 *                                      {@see TestCasesClient::agentName()} for help formatting this field.
 * @param string $formattedNamesElement Format of test case names: `projects/<Project ID>/locations/
 *                                      <Location ID>/agents/<AgentID>/testCases/<TestCase ID>`. Please see
 *                                      {@see TestCasesClient::testCaseName()} for help formatting this field.
 */
function batch_delete_test_cases_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $testCasesClient = new TestCasesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedNames = [$formattedNamesElement,];

    // Call the API and handle any network failures.
    try {
        $testCasesClient->batchDeleteTestCases($formattedParent, $formattedNames);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedNamesElement = TestCasesClient::testCaseName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[TEST_CASE]'
    );

    batch_delete_test_cases_sample($formattedParent, $formattedNamesElement);
}
// [END dialogflow_v3_generated_TestCases_BatchDeleteTestCases_sync]
