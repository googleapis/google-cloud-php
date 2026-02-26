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

// [START visionai_v1_generated_StreamsService_MaterializeChannel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\Channel;
use Google\Cloud\VisionAI\V1\StreamsServiceClient;
use Google\Rpc\Status;

/**
 * Materialize a channel.
 *
 * @param string $formattedParent        Value for parent. Please see
 *                                       {@see StreamsServiceClient::clusterName()} for help formatting this field.
 * @param string $channelId              Id of the channel.
 * @param string $formattedChannelStream Stream that is associated with this series. Please see
 *                                       {@see StreamsServiceClient::streamName()} for help formatting this field.
 * @param string $formattedChannelEvent  Event that is associated with this series. Please see
 *                                       {@see StreamsServiceClient::eventName()} for help formatting this field.
 */
function materialize_channel_sample(
    string $formattedParent,
    string $channelId,
    string $formattedChannelStream,
    string $formattedChannelEvent
): void {
    // Create a client.
    $streamsServiceClient = new StreamsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $channel = (new Channel())
        ->setStream($formattedChannelStream)
        ->setEvent($formattedChannelEvent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $streamsServiceClient->materializeChannel($formattedParent, $channelId, $channel);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Channel $result */
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
    $formattedParent = StreamsServiceClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
    $channelId = '[CHANNEL_ID]';
    $formattedChannelStream = StreamsServiceClient::streamName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[STREAM]'
    );
    $formattedChannelEvent = StreamsServiceClient::eventName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[EVENT]'
    );

    materialize_channel_sample(
        $formattedParent,
        $channelId,
        $formattedChannelStream,
        $formattedChannelEvent
    );
}
// [END visionai_v1_generated_StreamsService_MaterializeChannel_sync]
