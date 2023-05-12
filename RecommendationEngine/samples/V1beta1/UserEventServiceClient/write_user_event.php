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

// [START recommendationengine_v1beta1_generated_UserEventService_WriteUserEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\Client\UserEventServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\UserEvent;
use Google\Cloud\RecommendationEngine\V1beta1\UserInfo;
use Google\Cloud\RecommendationEngine\V1beta1\WriteUserEventRequest;

/**
 * Writes a single user event.
 *
 * @param string $formattedParent            The parent eventStore resource name, such as
 *                                           `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`. Please see
 *                                           {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
 * @param string $userEventEventType         User event type. Allowed values are:
 *
 *                                           * `add-to-cart` Products being added to cart.
 *                                           * `add-to-list` Items being added to a list (shopping list, favorites
 *                                           etc).
 *                                           * `category-page-view` Special pages such as sale or promotion pages
 *                                           viewed.
 *                                           * `checkout-start` User starting a checkout process.
 *                                           * `detail-page-view` Products detail page viewed.
 *                                           * `home-page-view` Homepage viewed.
 *                                           * `page-visit` Generic page visits not included in the event types above.
 *                                           * `purchase-complete` User finishing a purchase.
 *                                           * `refund` Purchased items being refunded or returned.
 *                                           * `remove-from-cart` Products being removed from cart.
 *                                           * `remove-from-list` Items being removed from a list.
 *                                           * `search` Product search.
 *                                           * `shopping-cart-page-view` User viewing a shopping cart.
 *                                           * `impression` List of items displayed. Used by Google Tag Manager.
 * @param string $userEventUserInfoVisitorId A unique identifier for tracking visitors with a length limit of
 *                                           128 bytes.
 *
 *                                           For example, this could be implemented with a http cookie, which should be
 *                                           able to uniquely identify a visitor on a single device. This unique
 *                                           identifier should not change if the visitor log in/out of the website.
 *                                           Maximum length 128 bytes. Cannot be empty.
 */
function write_user_event_sample(
    string $formattedParent,
    string $userEventEventType,
    string $userEventUserInfoVisitorId
): void {
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare the request message.
    $userEventUserInfo = (new UserInfo())
        ->setVisitorId($userEventUserInfoVisitorId);
    $userEvent = (new UserEvent())
        ->setEventType($userEventEventType)
        ->setUserInfo($userEventUserInfo);
    $request = (new WriteUserEventRequest())
        ->setParent($formattedParent)
        ->setUserEvent($userEvent);

    // Call the API and handle any network failures.
    try {
        /** @var UserEvent $response */
        $response = $userEventServiceClient->writeUserEvent($request);
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
    $userEventEventType = '[EVENT_TYPE]';
    $userEventUserInfoVisitorId = '[VISITOR_ID]';

    write_user_event_sample($formattedParent, $userEventEventType, $userEventUserInfoVisitorId);
}
// [END recommendationengine_v1beta1_generated_UserEventService_WriteUserEvent_sync]
