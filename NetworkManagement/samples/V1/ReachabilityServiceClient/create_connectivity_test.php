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

// [START networkmanagement_v1_generated_ReachabilityService_CreateConnectivityTest_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkManagement\V1\ConnectivityTest;
use Google\Cloud\NetworkManagement\V1\Endpoint;
use Google\Cloud\NetworkManagement\V1\ReachabilityServiceClient;
use Google\Rpc\Status;

/**
 * Creates a new Connectivity Test.
 * After you create a test, the reachability analysis is performed as part
 * of the long running operation, which completes when the analysis completes.
 *
 * If the endpoint specifications in `ConnectivityTest` are invalid
 * (for example, containing non-existent resources in the network, or you
 * don't have read permissions to the network configurations of listed
 * projects), then the reachability result returns a value of `UNKNOWN`.
 *
 * If the endpoint specifications in `ConnectivityTest` are
 * incomplete, the reachability result returns a value of
 * <code>AMBIGUOUS</code>. For more information,
 * see the Connectivity Test documentation.
 *
 * @param string $parent       The parent resource of the Connectivity Test to create:
 *                             `projects/{project_id}/locations/global`
 * @param string $testId       The logical name of the Connectivity Test in your project
 *                             with the following restrictions:
 *
 *                             * Must contain only lowercase letters, numbers, and hyphens.
 *                             * Must start with a letter.
 *                             * Must be between 1-40 characters.
 *                             * Must end with a number or a letter.
 *                             * Must be unique within the customer project
 * @param string $resourceName Unique name of the resource using the form:
 *                             `projects/{project_id}/locations/global/connectivityTests/{test}`
 */
function create_connectivity_test_sample(
    string $parent,
    string $testId,
    string $resourceName
): void {
    // Create a client.
    $reachabilityServiceClient = new ReachabilityServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $resourceSource = new Endpoint();
    $resourceDestination = new Endpoint();
    $resource = (new ConnectivityTest())
        ->setName($resourceName)
        ->setSource($resourceSource)
        ->setDestination($resourceDestination);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $reachabilityServiceClient->createConnectivityTest($parent, $testId, $resource);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConnectivityTest $result */
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
    $parent = '[PARENT]';
    $testId = '[TEST_ID]';
    $resourceName = '[NAME]';

    create_connectivity_test_sample($parent, $testId, $resourceName);
}
// [END networkmanagement_v1_generated_ReachabilityService_CreateConnectivityTest_sync]
