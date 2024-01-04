<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudchannel_v1_generated_CloudChannelService_UnregisterSubscriber_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\UnregisterSubscriberRequest;
use Google\Cloud\Channel\V1\UnregisterSubscriberResponse;

/**
 * Unregisters a service account with subscriber privileges on the Cloud
 * Pub/Sub topic created for this Channel Services account. If there are no
 * service accounts left with subscriber privileges, this deletes the topic.
 * You can call ListSubscribers to check for these accounts.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request and the
 * provided reseller account are different, or the impersonated user
 * is not a super admin.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * NOT_FOUND: The topic resource doesn't exist.
 * * INTERNAL: Any non-user error related to a technical issue in the
 * backend. Contact Cloud Channel support.
 * * UNKNOWN: Any non-user error related to a technical issue in the backend.
 * Contact Cloud Channel support.
 *
 * Return value:
 * The topic name that unregistered the service email address.
 * Returns a success response if the service email address wasn't registered
 * with the topic.
 *
 * @param string $account        Resource name of the account.
 * @param string $serviceAccount Service account to unregister from subscriber access to the
 *                               topic.
 */
function unregister_subscriber_sample(string $account, string $serviceAccount): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new UnregisterSubscriberRequest())
        ->setAccount($account)
        ->setServiceAccount($serviceAccount);

    // Call the API and handle any network failures.
    try {
        /** @var UnregisterSubscriberResponse $response */
        $response = $cloudChannelServiceClient->unregisterSubscriber($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $account = '[ACCOUNT]';
    $serviceAccount = '[SERVICE_ACCOUNT]';

    unregister_subscriber_sample($account, $serviceAccount);
}
// [END cloudchannel_v1_generated_CloudChannelService_UnregisterSubscriber_sync]
