<?php
/*
 * Copyright 2025 Google LLC
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

// [START aiplatform_v1_generated_ReasoningEngineService_CreateReasoningEngine_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\ReasoningEngineServiceClient;
use Google\Cloud\AIPlatform\V1\CreateReasoningEngineRequest;
use Google\Cloud\AIPlatform\V1\ReasoningEngine;
use Google\Rpc\Status;

/**
 * Creates a reasoning engine.
 *
 * @param string $formattedParent            The resource name of the Location to create the ReasoningEngine
 *                                           in. Format: `projects/{project}/locations/{location}`
 *                                           Please see {@see ReasoningEngineServiceClient::locationName()} for help formatting this field.
 * @param string $reasoningEngineDisplayName The display name of the ReasoningEngine.
 */
function create_reasoning_engine_sample(
    string $formattedParent,
    string $reasoningEngineDisplayName
): void {
    // Create a client.
    $reasoningEngineServiceClient = new ReasoningEngineServiceClient();

    // Prepare the request message.
    $reasoningEngine = (new ReasoningEngine())
        ->setDisplayName($reasoningEngineDisplayName);
    $request = (new CreateReasoningEngineRequest())
        ->setParent($formattedParent)
        ->setReasoningEngine($reasoningEngine);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $reasoningEngineServiceClient->createReasoningEngine($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ReasoningEngine $result */
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
    $formattedParent = ReasoningEngineServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $reasoningEngineDisplayName = '[DISPLAY_NAME]';

    create_reasoning_engine_sample($formattedParent, $reasoningEngineDisplayName);
}
// [END aiplatform_v1_generated_ReasoningEngineService_CreateReasoningEngine_sync]
