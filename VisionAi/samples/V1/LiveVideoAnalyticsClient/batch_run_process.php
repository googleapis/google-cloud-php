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

// [START visionai_v1_generated_LiveVideoAnalytics_BatchRunProcess_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\BatchRunProcessResponse;
use Google\Cloud\VisionAI\V1\CreateProcessRequest;
use Google\Cloud\VisionAI\V1\LiveVideoAnalyticsClient;
use Google\Cloud\VisionAI\V1\Process;
use Google\Rpc\Status;

/**
 * Run all of the processes to "completion". Max time for each process is
 * the LRO time limit.
 *
 * @param string $formattedParent                  The parent resource shared by all processes being created. Please see
 *                                                 {@see LiveVideoAnalyticsClient::clusterName()} for help formatting this field.
 * @param string $formattedRequestsParent          Value for parent. Please see
 *                                                 {@see LiveVideoAnalyticsClient::clusterName()} for help formatting this field.
 * @param string $requestsProcessId                Id of the requesting object.
 * @param string $formattedRequestsProcessAnalysis Reference to an existing Analysis resource. Please see
 *                                                 {@see LiveVideoAnalyticsClient::analysisName()} for help formatting this field.
 */
function batch_run_process_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsProcessId,
    string $formattedRequestsProcessAnalysis
): void {
    // Create a client.
    $liveVideoAnalyticsClient = new LiveVideoAnalyticsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestsProcess = (new Process())
        ->setAnalysis($formattedRequestsProcessAnalysis);
    $createProcessRequest = (new CreateProcessRequest())
        ->setParent($formattedRequestsParent)
        ->setProcessId($requestsProcessId)
        ->setProcess($requestsProcess);
    $requests = [$createProcessRequest,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $liveVideoAnalyticsClient->batchRunProcess($formattedParent, $requests);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchRunProcessResponse $result */
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
    $formattedParent = LiveVideoAnalyticsClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
    $formattedRequestsParent = LiveVideoAnalyticsClient::clusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]'
    );
    $requestsProcessId = '[PROCESS_ID]';
    $formattedRequestsProcessAnalysis = LiveVideoAnalyticsClient::analysisName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[ANALYSIS]'
    );

    batch_run_process_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsProcessId,
        $formattedRequestsProcessAnalysis
    );
}
// [END visionai_v1_generated_LiveVideoAnalytics_BatchRunProcess_sync]
