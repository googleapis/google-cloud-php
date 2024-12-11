<?php
/*
 * Copyright 2024 Google LLC
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

// [START eventarc_v1_generated_Eventarc_CreatePipeline_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\Client\EventarcClient;
use Google\Cloud\Eventarc\V1\CreatePipelineRequest;
use Google\Cloud\Eventarc\V1\Pipeline;
use Google\Cloud\Eventarc\V1\Pipeline\Destination;
use Google\Rpc\Status;

/**
 * Create a new Pipeline in a particular project and location.
 *
 * @param string $formattedParent The parent collection in which to add this pipeline. Please see
 *                                {@see EventarcClient::locationName()} for help formatting this field.
 * @param string $pipelineId      The user-provided ID to be assigned to the Pipeline.
 */
function create_pipeline_sample(string $formattedParent, string $pipelineId): void
{
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare the request message.
    $pipelineDestinations = [new Destination()];
    $pipeline = (new Pipeline())
        ->setDestinations($pipelineDestinations);
    $request = (new CreatePipelineRequest())
        ->setParent($formattedParent)
        ->setPipeline($pipeline)
        ->setPipelineId($pipelineId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->createPipeline($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Pipeline $result */
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
    $formattedParent = EventarcClient::locationName('[PROJECT]', '[LOCATION]');
    $pipelineId = '[PIPELINE_ID]';

    create_pipeline_sample($formattedParent, $pipelineId);
}
// [END eventarc_v1_generated_Eventarc_CreatePipeline_sync]
