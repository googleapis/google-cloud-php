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

// [START retail_v2_generated_UserEventService_PurgeUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\PurgeUserEventsResponse;
use Google\Cloud\Retail\V2\UserEventServiceClient;
use Google\Rpc\Status;

/**
 * Deletes permanently all user events specified by the filter provided.
 * Depending on the number of events specified by the filter, this operation
 * could take hours or days to complete. To test a filter, use the list
 * command first.
 *
 * @param string $formattedParent The resource name of the catalog under which the events are
 *                                created. The format is
 *                                `projects/${projectId}/locations/global/catalogs/${catalogId}`
 *                                Please see {@see UserEventServiceClient::catalogName()} for help formatting this field.
 * @param string $filter          The filter string to specify the events to be deleted with a
 *                                length limit of 5,000 characters. Empty string filter is not allowed. The
 *                                eligible fields for filtering are:
 *
 *                                * `eventType`: Double quoted
 *                                [UserEvent.event_type][google.cloud.retail.v2.UserEvent.event_type] string.
 *                                * `eventTime`: in ISO 8601 "zulu" format.
 *                                * `visitorId`: Double quoted string. Specifying this will delete all
 *                                events associated with a visitor.
 *                                * `userId`: Double quoted string. Specifying this will delete all events
 *                                associated with a user.
 *
 *                                Examples:
 *
 *                                * Deleting all events in a time range:
 *                                `eventTime > "2012-04-23T18:25:43.511Z"
 *                                eventTime < "2012-04-23T18:30:43.511Z"`
 *                                * Deleting specific eventType in time range:
 *                                `eventTime > "2012-04-23T18:25:43.511Z" eventType = "detail-page-view"`
 *                                * Deleting all events for a specific visitor:
 *                                `visitorId = "visitor1024"`
 *
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
    $formattedParent = UserEventServiceClient::catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
    $filter = '[FILTER]';

    purge_user_events_sample($formattedParent, $filter);
}
// [END retail_v2_generated_UserEventService_PurgeUserEvents_sync]
