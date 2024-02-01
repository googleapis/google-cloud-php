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

// [START pubsub_v1_generated_Subscriber_ModifyAckDeadline_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\ModifyAckDeadlineRequest;

/**
 * Modifies the ack deadline for a specific message. This method is useful
 * to indicate that more time is needed to process a message by the
 * subscriber, or to make the message available for redelivery if the
 * processing was interrupted. Note that this does not modify the
 * subscription-level `ackDeadlineSeconds` used for subsequent messages.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function modify_ack_deadline_sample(): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare the request message.
    $request = new ModifyAckDeadlineRequest();

    // Call the API and handle any network failures.
    try {
        $subscriberClient->modifyAckDeadline($request);
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END pubsub_v1_generated_Subscriber_ModifyAckDeadline_sync]
