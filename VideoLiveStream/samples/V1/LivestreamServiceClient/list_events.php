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

// [START livestream_v1_generated_LivestreamService_ListEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Video\LiveStream\V1\Event;
use Google\Cloud\Video\LiveStream\V1\LivestreamServiceClient;

/**
 * Returns a list of all events in the specified channel.
 *
 * @param string $formattedParent The parent channel for the resource, in the form of:
 *                                `projects/{project}/locations/{location}/channels/{channelId}`. Please see
 *                                {@see LivestreamServiceClient::channelName()} for help formatting this field.
 */
function list_events_sample(string $formattedParent): void
{
    // Create a client.
    $livestreamServiceClient = new LivestreamServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $livestreamServiceClient->listEvents($formattedParent);

        /** @var Event $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = LivestreamServiceClient::channelName('[PROJECT]', '[LOCATION]', '[CHANNEL]');

    list_events_sample($formattedParent);
}
// [END livestream_v1_generated_LivestreamService_ListEvents_sync]
