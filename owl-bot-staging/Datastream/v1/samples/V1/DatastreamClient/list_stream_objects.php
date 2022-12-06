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

// [START datastream_v1_generated_Datastream_ListStreamObjects_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Datastream\V1\DatastreamClient;
use Google\Cloud\Datastream\V1\StreamObject;

/**
 * Use this method to list the objects of a specific stream.
 *
 * @param string $formattedParent The parent stream that owns the collection of objects. Please see
 *                                {@see DatastreamClient::streamName()} for help formatting this field.
 */
function list_stream_objects_sample(string $formattedParent): void
{
    // Create a client.
    $datastreamClient = new DatastreamClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $datastreamClient->listStreamObjects($formattedParent);

        /** @var StreamObject $element */
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
    $formattedParent = DatastreamClient::streamName('[PROJECT]', '[LOCATION]', '[STREAM]');

    list_stream_objects_sample($formattedParent);
}
// [END datastream_v1_generated_Datastream_ListStreamObjects_sync]
