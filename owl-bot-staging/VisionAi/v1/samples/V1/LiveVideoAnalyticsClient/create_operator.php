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

// [START visionai_v1_generated_LiveVideoAnalytics_CreateOperator_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\LiveVideoAnalyticsClient;
use Google\Cloud\VisionAI\V1\Operator;
use Google\Rpc\Status;

/**
 * Creates a new Operator in a given project and location.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see LiveVideoAnalyticsClient::locationName()} for help formatting this field.
 * @param string $operatorId      Id of the requesting object.
 */
function create_operator_sample(string $formattedParent, string $operatorId): void
{
    // Create a client.
    $liveVideoAnalyticsClient = new LiveVideoAnalyticsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $operator = new Operator();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $liveVideoAnalyticsClient->createOperator($formattedParent, $operatorId, $operator);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Operator $result */
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
    $formattedParent = LiveVideoAnalyticsClient::locationName('[PROJECT]', '[LOCATION]');
    $operatorId = '[OPERATOR_ID]';

    create_operator_sample($formattedParent, $operatorId);
}
// [END visionai_v1_generated_LiveVideoAnalytics_CreateOperator_sync]
