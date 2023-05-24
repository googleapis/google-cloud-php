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

// [START assuredworkloads_v1_generated_AssuredWorkloadsService_CreateWorkload_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1\CreateWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\Workload;
use Google\Cloud\AssuredWorkloads\V1\Workload\ComplianceRegime;
use Google\Rpc\Status;

/**
 * Creates Assured Workload.
 *
 * @param string $formattedParent          The resource name of the new Workload's parent.
 *                                         Must be of the form `organizations/{org_id}/locations/{location_id}`. Please see
 *                                         {@see AssuredWorkloadsServiceClient::locationName()} for help formatting this field.
 * @param string $workloadDisplayName      The user-assigned display name of the Workload.
 *                                         When present it must be between 4 to 30 characters.
 *                                         Allowed characters are: lowercase and uppercase letters, numbers,
 *                                         hyphen, and spaces.
 *
 *                                         Example: My Workload
 * @param int    $workloadComplianceRegime Immutable. Compliance Regime associated with this workload.
 */
function create_workload_sample(
    string $formattedParent,
    string $workloadDisplayName,
    int $workloadComplianceRegime
): void {
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Prepare the request message.
    $workload = (new Workload())
        ->setDisplayName($workloadDisplayName)
        ->setComplianceRegime($workloadComplianceRegime);
    $request = (new CreateWorkloadRequest())
        ->setParent($formattedParent)
        ->setWorkload($workload);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $assuredWorkloadsServiceClient->createWorkload($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Workload $result */
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
    $formattedParent = AssuredWorkloadsServiceClient::locationName('[ORGANIZATION]', '[LOCATION]');
    $workloadDisplayName = '[DISPLAY_NAME]';
    $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;

    create_workload_sample($formattedParent, $workloadDisplayName, $workloadComplianceRegime);
}
// [END assuredworkloads_v1_generated_AssuredWorkloadsService_CreateWorkload_sync]
