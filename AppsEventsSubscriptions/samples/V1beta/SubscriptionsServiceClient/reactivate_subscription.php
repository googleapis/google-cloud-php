<?php
/*
 * Copyright 2025 Google LLC
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

// [START workspaceevents_v1beta_generated_SubscriptionsService_ReactivateSubscription_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Apps\Events\Subscriptions\V1beta\Client\SubscriptionsServiceClient;
use Google\Apps\Events\Subscriptions\V1beta\ReactivateSubscriptionRequest;
use Google\Apps\Events\Subscriptions\V1beta\Subscription;
use Google\Rpc\Status;

/**
 * Reactivates a suspended Google Workspace subscription.
 *
 * This method resets your subscription's `State` field to `ACTIVE`. Before
 * you use this method, you must fix the error that suspended the
 * subscription. This method will ignore or reject any subscription that
 * isn't currently in a suspended state. To learn how to use this method, see
 * [Reactivate a Google Workspace
 * subscription](https://developers.google.com/workspace/events/guides/reactivate-subscription).
 *
 * @param string $formattedName Resource name of the subscription.
 *
 *                              Format: `subscriptions/{subscription}`
 *                              Please see {@see SubscriptionsServiceClient::subscriptionName()} for help formatting this field.
 */
function reactivate_subscription_sample(string $formattedName): void
{
    // Create a client.
    $subscriptionsServiceClient = new SubscriptionsServiceClient();

    // Prepare the request message.
    $request = (new ReactivateSubscriptionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $subscriptionsServiceClient->reactivateSubscription($request);
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
    $formattedName = SubscriptionsServiceClient::subscriptionName('[SUBSCRIPTION]');

    reactivate_subscription_sample($formattedName);
}
// [END workspaceevents_v1beta_generated_SubscriptionsService_ReactivateSubscription_sync]
