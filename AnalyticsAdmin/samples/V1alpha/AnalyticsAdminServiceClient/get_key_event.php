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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_GetKeyEvent_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\GetKeyEventRequest;
use Google\Analytics\Admin\V1alpha\KeyEvent;
use Google\ApiCore\ApiException;

/**
 * Retrieve a single Key Event.
 *
 * @param string $formattedName The resource name of the Key Event to retrieve.
 *                              Format: properties/{property}/keyEvents/{key_event}
 *                              Example: "properties/123/keyEvents/456"
 *                              Please see {@see AnalyticsAdminServiceClient::keyEventName()} for help formatting this field.
 */
function get_key_event_sample(string $formattedName): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $request = (new GetKeyEventRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var KeyEvent $response */
        $response = $analyticsAdminServiceClient->getKeyEvent($request);
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
    $formattedName = AnalyticsAdminServiceClient::keyEventName('[PROPERTY]', '[KEY_EVENT]');

    get_key_event_sample($formattedName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_GetKeyEvent_sync]
