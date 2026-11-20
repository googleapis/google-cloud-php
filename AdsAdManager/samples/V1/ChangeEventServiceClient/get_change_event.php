<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_ChangeEventService_GetChangeEvent_sync]
use Google\Ads\AdManager\V1\ChangeEvent;
use Google\Ads\AdManager\V1\Client\ChangeEventServiceClient;
use Google\Ads\AdManager\V1\GetChangeEventRequest;
use Google\ApiCore\ApiException;

/**
 * Retrieves a `ChangeEvent` object.
 *
 * @param string $formattedName The resource name of the ChangeEvent.
 *                              Format: `networks/{network_code}/changeEvents/{change_event_id}`
 *                              Please see {@see ChangeEventServiceClient::changeEventName()} for help formatting this field.
 */
function get_change_event_sample(string $formattedName): void
{
    // Create a client.
    $changeEventServiceClient = new ChangeEventServiceClient();

    // Prepare the request message.
    $request = (new GetChangeEventRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ChangeEvent $response */
        $response = $changeEventServiceClient->getChangeEvent($request);
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
    $formattedName = ChangeEventServiceClient::changeEventName('[NETWORK_CODE]', '[CHANGE_EVENT]');

    get_change_event_sample($formattedName);
}
// [END admanager_v1_generated_ChangeEventService_GetChangeEvent_sync]
