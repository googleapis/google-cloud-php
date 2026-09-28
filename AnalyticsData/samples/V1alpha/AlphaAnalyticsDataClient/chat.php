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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_Chat_sync]
use Google\Analytics\Data\V1alpha\ChatRequest;
use Google\Analytics\Data\V1alpha\ChatResponse;
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\ApiCore\ApiException;

/**
 * Provides a chat interface for interacting with Google Analytics data
 * through the API.
 *
 * This product uses AI and may display inaccurate info. Your chat activity
 * may be used to improve the product and your use is subject to Google's
 * [Terms](https://policies.google.com/terms),
 * [AI Use
 * Policy](https://policies.google.com/terms/generative-ai/use-policy), and
 * [Privacy Policy](https://policies.google.com/privacy).
 * [Learn more about Chat AI
 * Privacy](https://support.google.com/helpguide/answer/14185196).
 *
 * @param string $formattedProperty The property to chat about.
 *                                  Format: properties/{property}
 *                                  Please see {@see AlphaAnalyticsDataClient::propertyName()} for help formatting this field.
 * @param string $userQuery         The user's query.
 */
function chat_sample(string $formattedProperty, string $userQuery): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new ChatRequest())
        ->setProperty($formattedProperty)
        ->setUserQuery($userQuery);

    // Call the API and handle any network failures.
    try {
        /** @var ChatResponse $response */
        $response = $alphaAnalyticsDataClient->chat($request);
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
    $formattedProperty = AlphaAnalyticsDataClient::propertyName('[PROPERTY]');
    $userQuery = '[USER_QUERY]';

    chat_sample($formattedProperty, $userQuery);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_Chat_sync]
