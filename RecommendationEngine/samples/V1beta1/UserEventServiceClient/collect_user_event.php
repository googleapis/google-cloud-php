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

// [START recommendationengine_v1beta1_generated_UserEventService_CollectUserEvent_sync]
use Google\ApiCore\ApiException;
use Google\Api\HttpBody;
use Google\Cloud\RecommendationEngine\V1beta1\Client\UserEventServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\CollectUserEventRequest;

/**
 * Writes a single user event from the browser. This uses a GET request to
 * due to browser restriction of POST-ing to a 3rd party domain.
 *
 * This method is used only by the Recommendations AI JavaScript pixel.
 * Users should not call this method directly.
 *
 * @param string $formattedParent The parent eventStore name, such as
 *                                `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`. Please see
 *                                {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
 * @param string $userEvent       URL encoded UserEvent proto.
 */
function collect_user_event_sample(string $formattedParent, string $userEvent): void
{
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare the request message.
    $request = (new CollectUserEventRequest())
        ->setParent($formattedParent)
        ->setUserEvent($userEvent);

    // Call the API and handle any network failures.
    try {
        /** @var HttpBody $response */
        $response = $userEventServiceClient->collectUserEvent($request);
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
    $formattedParent = UserEventServiceClient::eventStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]'
    );
    $userEvent = '[USER_EVENT]';

    collect_user_event_sample($formattedParent, $userEvent);
}
// [END recommendationengine_v1beta1_generated_UserEventService_CollectUserEvent_sync]
