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

// [START workspaceevents_v1_generated_SubscriptionsService_ListSubscriptions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Events\Subscriptions\V1\Client\SubscriptionsServiceClient;
use Google\Apps\Events\Subscriptions\V1\ListSubscriptionsRequest;
use Google\Apps\Events\Subscriptions\V1\Subscription;

/**
 * Lists Google Workspace subscriptions. To learn how to use this method, see
 * [List Google Workspace
 * subscriptions](https://developers.google.com/workspace/events/guides/list-subscriptions).
 *
 * @param string $filter A query filter.
 *
 *                       You can filter subscriptions by event type (`event_types`)
 *                       and target resource (`target_resource`).
 *
 *                       You must specify at least one event type in your query. To filter for
 *                       multiple event types, use the `OR` operator.
 *
 *                       To filter by both event type and target resource, use the `AND` operator
 *                       and specify the full resource name, such as
 *                       `//chat.googleapis.com/spaces/{space}`.
 *
 *                       For example, the following queries are valid:
 *
 *                       ```
 *                       event_types:"google.workspace.chat.membership.v1.updated" OR
 *                       event_types:"google.workspace.chat.message.v1.created"
 *
 *                       event_types:"google.workspace.chat.message.v1.created" AND
 *                       target_resource="//chat.googleapis.com/spaces/{space}"
 *
 *                       ( event_types:"google.workspace.chat.membership.v1.updated" OR
 *                       event_types:"google.workspace.chat.message.v1.created" ) AND
 *                       target_resource="//chat.googleapis.com/spaces/{space}"
 *                       ```
 *
 *                       The server rejects invalid queries with an `INVALID_ARGUMENT`
 *                       error.
 */
function list_subscriptions_sample(string $filter): void
{
    // Create a client.
    $subscriptionsServiceClient = new SubscriptionsServiceClient();

    // Prepare the request message.
    $request = (new ListSubscriptionsRequest())
        ->setFilter($filter);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $subscriptionsServiceClient->listSubscriptions($request);

        /** @var Subscription $element */
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
    $filter = '[FILTER]';

    list_subscriptions_sample($filter);
}
// [END workspaceevents_v1_generated_SubscriptionsService_ListSubscriptions_sync]
