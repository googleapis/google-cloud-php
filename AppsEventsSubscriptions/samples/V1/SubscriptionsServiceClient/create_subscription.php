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

// [START workspaceevents_v1_generated_SubscriptionsService_CreateSubscription_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Apps\Events\Subscriptions\V1\Client\SubscriptionsServiceClient;
use Google\Apps\Events\Subscriptions\V1\CreateSubscriptionRequest;
use Google\Apps\Events\Subscriptions\V1\NotificationEndpoint;
use Google\Apps\Events\Subscriptions\V1\Subscription;
use Google\Rpc\Status;

/**
 * Creates a Google Workspace subscription. To learn how to use this
 * method, see [Create a Google Workspace
 * subscription](https://developers.google.com/workspace/events/guides/create-subscription).
 *
 * @param string $subscriptionTargetResource    Immutable. The Google Workspace resource that's monitored for
 *                                              events, formatted as the [full resource
 *                                              name](https://google.aip.dev/122#full-resource-names). To learn about
 *                                              target resources and the events that they support, see [Supported Google
 *                                              Workspace
 *                                              events](https://developers.google.com/workspace/events#supported-events).
 *
 *                                              A user can only authorize your app to create one subscription for a given
 *                                              target resource. If your app tries to create another subscription with the
 *                                              same user credentials, the request returns an `ALREADY_EXISTS` error.
 * @param string $subscriptionEventTypesElement Immutable. Unordered list. Input for creating a subscription.
 *                                              Otherwise, output only. One or more types of events to receive about the
 *                                              target resource. Formatted according to the CloudEvents specification.
 *
 *                                              The supported event types depend on the target resource of your
 *                                              subscription. For details, see [Supported Google Workspace
 *                                              events](https://developers.google.com/workspace/events/guides#supported-events).
 *
 *                                              By default, you also receive events about the [lifecycle of your
 *                                              subscription](https://developers.google.com/workspace/events/guides/events-lifecycle).
 *                                              You don't need to specify lifecycle events for this field.
 *
 *                                              If you specify an event type that doesn't exist for the target resource,
 *                                              the request returns an HTTP `400 Bad Request` status code.
 */
function create_subscription_sample(
    string $subscriptionTargetResource,
    string $subscriptionEventTypesElement
): void {
    // Create a client.
    $subscriptionsServiceClient = new SubscriptionsServiceClient();

    // Prepare the request message.
    $subscriptionEventTypes = [$subscriptionEventTypesElement,];
    $subscriptionNotificationEndpoint = new NotificationEndpoint();
    $subscription = (new Subscription())
        ->setTargetResource($subscriptionTargetResource)
        ->setEventTypes($subscriptionEventTypes)
        ->setNotificationEndpoint($subscriptionNotificationEndpoint);
    $request = (new CreateSubscriptionRequest())
        ->setSubscription($subscription);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $subscriptionsServiceClient->createSubscription($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Subscription $result */
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
    $subscriptionTargetResource = '[TARGET_RESOURCE]';
    $subscriptionEventTypesElement = '[EVENT_TYPES]';

    create_subscription_sample($subscriptionTargetResource, $subscriptionEventTypesElement);
}
// [END workspaceevents_v1_generated_SubscriptionsService_CreateSubscription_sync]
