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

// [START pubsub_v1_generated_Subscriber_ModifyPushConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\ModifyPushConfigRequest;

/**
 * Modifies the `PushConfig` for a specified subscription.
 *
 * This may be used to change a push subscription to a pull one (signified by
 * an empty `PushConfig`) or vice versa, or change the endpoint URL and other
 * attributes of a push subscription. Messages will accumulate for delivery
 * continuously through the call regardless of changes to the `PushConfig`.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function modify_push_config_sample(): void
{
    // Create a client.
    $subscriberClient = new SubscriberClient();

    // Prepare the request message.
    $request = new ModifyPushConfigRequest();

    // Call the API and handle any network failures.
    try {
        $subscriberClient->modifyPushConfig($request);
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END pubsub_v1_generated_Subscriber_ModifyPushConfig_sync]
