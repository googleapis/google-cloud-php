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

// [START eventarc_v1_generated_Eventarc_CreateChannel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\Channel;
use Google\Cloud\Eventarc\V1\EventarcClient;
use Google\Rpc\Status;

/**
 * Create a new channel in a particular project and location.
 *
 * @param string $formattedParent The parent collection in which to add this channel. Please see
 *                                {@see EventarcClient::locationName()} for help formatting this field.
 * @param string $channelName     The resource name of the channel. Must be unique within the
 *                                location on the project and must be in
 *                                `projects/{project}/locations/{location}/channels/{channel_id}` format.
 * @param string $channelId       The user-provided ID to be assigned to the channel.
 * @param bool   $validateOnly    If set, validate the request and preview the review, but do not
 *                                post it.
 */
function create_channel_sample(
    string $formattedParent,
    string $channelName,
    string $channelId,
    bool $validateOnly
): void {
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $channel = (new Channel())
        ->setName($channelName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->createChannel($formattedParent, $channel, $channelId, $validateOnly);
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
    $formattedParent = EventarcClient::locationName('[PROJECT]', '[LOCATION]');
    $channelName = '[NAME]';
    $channelId = '[CHANNEL_ID]';
    $validateOnly = false;

    create_channel_sample($formattedParent, $channelName, $channelId, $validateOnly);
}
// [END eventarc_v1_generated_Eventarc_CreateChannel_sync]
