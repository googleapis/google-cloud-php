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

// [START assuredworkloads_v1_generated_AssuredWorkloadsService_AcknowledgeViolation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1\AcknowledgeViolationRequest;
use Google\Cloud\AssuredWorkloads\V1\AcknowledgeViolationResponse;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;

/**
 * Acknowledges an existing violation. By acknowledging a violation, users
 * acknowledge the existence of a compliance violation in their workload and
 * decide to ignore it due to a valid business justification. Acknowledgement
 * is a permanent operation and it cannot be reverted.
 *
 * @param string $name    The resource name of the Violation to acknowledge.
 *                        Format:
 *                        organizations/{organization}/locations/{location}/workloads/{workload}/violations/{violation}
 * @param string $comment Business justification explaining the need for violation acknowledgement
 */
function acknowledge_violation_sample(string $name, string $comment): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Prepare the request message.
    $request = (new AcknowledgeViolationRequest())
        ->setName($name)
        ->setComment($comment);

    // Call the API and handle any network failures.
    try {
        /** @var AcknowledgeViolationResponse $response */
        $response = $assuredWorkloadsServiceClient->acknowledgeViolation($request);
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
    $name = '[NAME]';
    $comment = '[COMMENT]';

    acknowledge_violation_sample($name, $comment);
}
// [END assuredworkloads_v1_generated_AssuredWorkloadsService_AcknowledgeViolation_sync]
