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

// [START datastream_v1_generated_Datastream_RunStream_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Datastream\V1\Client\DatastreamClient;
use Google\Cloud\Datastream\V1\RunStreamRequest;
use Google\Cloud\Datastream\V1\Stream;
use Google\Rpc\Status;

/**
 * Use this method to start, resume or recover a stream with a non default CDC
 * strategy.
 *
 * @param string $formattedName Name of the stream resource to start, in the format:
 *                              projects/{project_id}/locations/{location}/streams/{stream_name}
 *                              Please see {@see DatastreamClient::streamName()} for help formatting this field.
 */
function run_stream_sample(string $formattedName): void
{
    // Create a client.
    $datastreamClient = new DatastreamClient();

    // Prepare the request message.
    $request = (new RunStreamRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datastreamClient->runStream($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Stream $result */
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
    $formattedName = DatastreamClient::streamName('[PROJECT]', '[LOCATION]', '[STREAM]');

    run_stream_sample($formattedName);
}
// [END datastream_v1_generated_Datastream_RunStream_sync]
