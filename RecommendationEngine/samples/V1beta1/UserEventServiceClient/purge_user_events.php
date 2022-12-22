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

// [START recommendationengine_v1beta1_generated_UserEventService_PurgeUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\RecommendationEngine\V1beta1\PurgeUserEventsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\UserEventServiceClient;
use Google\Rpc\Status;

/**
 * Deletes permanently all user events specified by the filter provided.
 * Depending on the number of events specified by the filter, this operation
 * could take hours or days to complete. To test a filter, use the list
 * command first.
 *
 * @param string $formattedParent The resource name of the event_store under which the events are
 *                                created. The format is
 *                                `projects/${projectId}/locations/global/catalogs/${catalogId}/eventStores/${eventStoreId}`
 *                                Please see {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
 * @param string $filter          The filter string to specify the events to be deleted. Empty
 *                                string filter is not allowed. This filter can also be used with
 *                                ListUserEvents API to list events that will be deleted. The eligible fields
 *                                for filtering are:
 *                                * eventType - UserEvent.eventType field of type string.
 *                                * eventTime - in ISO 8601 "zulu" format.
 *                                * visitorId - field of type string. Specifying this will delete all events
 *                                associated with a visitor.
 *                                * userId - field of type string. Specifying this will delete all events
 *                                associated with a user.
 *                                Example 1: Deleting all events in a time range.
 *                                `eventTime > "2012-04-23T18:25:43.511Z" eventTime <
 *                                "2012-04-23T18:30:43.511Z"`
 *                                Example 2: Deleting specific eventType in time range.
 *                                `eventTime > "2012-04-23T18:25:43.511Z" eventType = "detail-page-view"`
 *                                Example 3: Deleting all events for a specific visitor
 *                                `visitorId = visitor1024`
 *                                The filtering fields are assumed to have an implicit AND.
 */
function purge_user_events_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $userEventServiceClient->purgeUserEvents($formattedParent, $filter);
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
    $formattedParent = UserEventServiceClient::eventStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]'
    );
    $filter = '[FILTER]';

    purge_user_events_sample($formattedParent, $filter);
}
// [END recommendationengine_v1beta1_generated_UserEventService_PurgeUserEvents_sync]
