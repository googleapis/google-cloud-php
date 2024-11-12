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

// [START dialogflow_v3_generated_TestCases_CalculateCoverage_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\CalculateCoverageRequest;
use Google\Cloud\Dialogflow\Cx\V3\CalculateCoverageRequest\CoverageType;
use Google\Cloud\Dialogflow\Cx\V3\CalculateCoverageResponse;
use Google\Cloud\Dialogflow\Cx\V3\Client\TestCasesClient;

/**
 * Calculates the test coverage for an agent.
 *
 * @param string $formattedAgent The agent to calculate coverage for.
 *                               Format: `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>`. Please see
 *                               {@see TestCasesClient::agentName()} for help formatting this field.
 * @param int    $type           The type of coverage requested.
 */
function calculate_coverage_sample(string $formattedAgent, int $type): void
{
    // Create a client.
    $testCasesClient = new TestCasesClient();

    // Prepare the request message.
    $request = (new CalculateCoverageRequest())
        ->setAgent($formattedAgent)
        ->setType($type);

    // Call the API and handle any network failures.
    try {
        /** @var CalculateCoverageResponse $response */
        $response = $testCasesClient->calculateCoverage($request);
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
    $formattedAgent = TestCasesClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');
    $type = CoverageType::COVERAGE_TYPE_UNSPECIFIED;

    calculate_coverage_sample($formattedAgent, $type);
}
// [END dialogflow_v3_generated_TestCases_CalculateCoverage_sync]
