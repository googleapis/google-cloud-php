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

// [START assuredworkloads_v1_generated_AssuredWorkloadsService_GetViolation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1\GetViolationRequest;
use Google\Cloud\AssuredWorkloads\V1\Violation;

/**
 * Retrieves Assured Workload Violation based on ID.
 *
 * @param string $formattedName The resource name of the Violation to fetch (ie. Violation.name).
 *                              Format:
 *                              organizations/{organization}/locations/{location}/workloads/{workload}/violations/{violation}
 *                              Please see {@see AssuredWorkloadsServiceClient::violationName()} for help formatting this field.
 */
function get_violation_sample(string $formattedName): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Prepare the request message.
    $request = (new GetViolationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Violation $response */
        $response = $assuredWorkloadsServiceClient->getViolation($request);
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
    $formattedName = AssuredWorkloadsServiceClient::violationName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[WORKLOAD]',
        '[VIOLATION]'
    );

    get_violation_sample($formattedName);
}
// [END assuredworkloads_v1_generated_AssuredWorkloadsService_GetViolation_sync]
