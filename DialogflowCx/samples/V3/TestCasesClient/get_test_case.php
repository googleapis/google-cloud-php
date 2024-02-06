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

// [START dialogflow_v3_generated_TestCases_GetTestCase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\TestCasesClient;
use Google\Cloud\Dialogflow\Cx\V3\GetTestCaseRequest;
use Google\Cloud\Dialogflow\Cx\V3\TestCase;

/**
 * Gets a test case.
 *
 * @param string $formattedName The name of the testcase.
 *                              Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent
 *                              ID>/testCases/<TestCase ID>`. Please see
 *                              {@see TestCasesClient::testCaseName()} for help formatting this field.
 */
function get_test_case_sample(string $formattedName): void
{
    // Create a client.
    $testCasesClient = new TestCasesClient();

    // Prepare the request message.
    $request = (new GetTestCaseRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var TestCase $response */
        $response = $testCasesClient->getTestCase($request);
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
    $formattedName = TestCasesClient::testCaseName('[PROJECT]', '[LOCATION]', '[AGENT]', '[TEST_CASE]');

    get_test_case_sample($formattedName);
}
// [END dialogflow_v3_generated_TestCases_GetTestCase_sync]
