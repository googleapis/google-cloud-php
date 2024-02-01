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

// [START recommendationengine_v1beta1_generated_UserEventService_PurgeUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\RecommendationEngine\V1beta1\Client\UserEventServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\PurgeUserEventsRequest;
use Google\Cloud\RecommendationEngine\V1beta1\PurgeUserEventsResponse;
use Google\Rpc\Status;

/**
 * Deletes permanently all user events specified by the filter provided.
 * Depending on the number of events specified by the filter, this operation
 * could take hours or days to complete. To test a filter, use the list
 * command first.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function purge_user_events_sample(): void
{
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare the request message.
    $request = new PurgeUserEventsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $userEventServiceClient->purgeUserEvents($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PurgeUserEventsResponse $result */
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
// [END recommendationengine_v1beta1_generated_UserEventService_PurgeUserEvents_sync]
