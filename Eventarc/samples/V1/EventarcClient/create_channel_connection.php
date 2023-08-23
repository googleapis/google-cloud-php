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

// [START eventarc_v1_generated_Eventarc_CreateChannelConnection_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\ChannelConnection;
use Google\Cloud\Eventarc\V1\EventarcClient;
use Google\Rpc\Status;

/**
 * Create a new ChannelConnection in a particular project and location.
 *
 * @param string $formattedParent                   The parent collection in which to add this channel connection. Please see
 *                                                  {@see EventarcClient::locationName()} for help formatting this field.
 * @param string $channelConnectionName             The name of the connection.
 * @param string $formattedChannelConnectionChannel The name of the connected subscriber Channel.
 *                                                  This is a weak reference to avoid cross project and cross accounts
 *                                                  references. This must be in
 *                                                  `projects/{project}/location/{location}/channels/{channel_id}` format. Please see
 *                                                  {@see EventarcClient::channelName()} for help formatting this field.
 * @param string $channelConnectionId               The user-provided ID to be assigned to the channel connection.
 */
function create_channel_connection_sample(
    string $formattedParent,
    string $channelConnectionName,
    string $formattedChannelConnectionChannel,
    string $channelConnectionId
): void {
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $channelConnection = (new ChannelConnection())
        ->setName($channelConnectionName)
        ->setChannel($formattedChannelConnectionChannel);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->createChannelConnection(
            $formattedParent,
            $channelConnection,
            $channelConnectionId
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ChannelConnection $result */
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
    $channelConnectionName = '[NAME]';
    $formattedChannelConnectionChannel = EventarcClient::channelName(
        '[PROJECT]',
        '[LOCATION]',
        '[CHANNEL]'
    );
    $channelConnectionId = '[CHANNEL_CONNECTION_ID]';

    create_channel_connection_sample(
        $formattedParent,
        $channelConnectionName,
        $formattedChannelConnectionChannel,
        $channelConnectionId
    );
}
// [END eventarc_v1_generated_Eventarc_CreateChannelConnection_sync]
