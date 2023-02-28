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

// [START retail_v2_generated_UserEventService_RejoinUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\RejoinUserEventsResponse;
use Google\Cloud\Retail\V2\UserEventServiceClient;
use Google\Rpc\Status;

/**
 * Starts a user event rejoin operation with latest product catalog. Events
 * will not be annotated with detailed product information if product is
 * missing from the catalog at the time the user event is ingested, and these
 * events are stored as unjoined events with a limited usage on training and
 * serving. This method can be used to start a join operation on specified
 * events with latest version of product catalog. It can also be used to
 * correct events joined with the wrong product catalog. A rejoin operation
 * can take hours or days to complete.
 *
 * @param string $parent The parent catalog resource name, such as
 *                       `projects/1234/locations/global/catalogs/default_catalog`.
 */
function rejoin_user_events_sample(string $parent): void
{
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $userEventServiceClient->rejoinUserEvents($parent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RejoinUserEventsResponse $result */
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
    $parent = '[PARENT]';

    rejoin_user_events_sample($parent);
}
// [END retail_v2_generated_UserEventService_RejoinUserEvents_sync]
