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

// [START datastream_v1_generated_Datastream_UpdateStream_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Datastream\V1\DatastreamClient;
use Google\Cloud\Datastream\V1\DestinationConfig;
use Google\Cloud\Datastream\V1\SourceConfig;
use Google\Cloud\Datastream\V1\Stream;
use Google\Rpc\Status;

/**
 * Use this method to update the configuration of a stream.
 *
 * @param string $streamDisplayName                                            Display name.
 * @param string $formattedStreamSourceConfigSourceConnectionProfile           Source connection profile resoource.
 *                                                                             Format: `projects/{project}/locations/{location}/connectionProfiles/{name}`
 *                                                                             Please see {@see DatastreamClient::connectionProfileName()} for help formatting this field.
 * @param string $formattedStreamDestinationConfigDestinationConnectionProfile Destination connection profile resource.
 *                                                                             Format: `projects/{project}/locations/{location}/connectionProfiles/{name}`
 *                                                                             Please see {@see DatastreamClient::connectionProfileName()} for help formatting this field.
 */
function update_stream_sample(
    string $streamDisplayName,
    string $formattedStreamSourceConfigSourceConnectionProfile,
    string $formattedStreamDestinationConfigDestinationConnectionProfile
): void {
    // Create a client.
    $datastreamClient = new DatastreamClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $streamSourceConfig = (new SourceConfig())
        ->setSourceConnectionProfile($formattedStreamSourceConfigSourceConnectionProfile);
    $streamDestinationConfig = (new DestinationConfig())
        ->setDestinationConnectionProfile($formattedStreamDestinationConfigDestinationConnectionProfile);
    $stream = (new Stream())
        ->setDisplayName($streamDisplayName)
        ->setSourceConfig($streamSourceConfig)
        ->setDestinationConfig($streamDestinationConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $datastreamClient->updateStream($stream);
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
    $streamDisplayName = '[DISPLAY_NAME]';
    $formattedStreamSourceConfigSourceConnectionProfile = DatastreamClient::connectionProfileName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION_PROFILE]'
    );
    $formattedStreamDestinationConfigDestinationConnectionProfile = DatastreamClient::connectionProfileName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION_PROFILE]'
    );

    update_stream_sample(
        $streamDisplayName,
        $formattedStreamSourceConfigSourceConnectionProfile,
        $formattedStreamDestinationConfigDestinationConnectionProfile
    );
}
// [END datastream_v1_generated_Datastream_UpdateStream_sync]
