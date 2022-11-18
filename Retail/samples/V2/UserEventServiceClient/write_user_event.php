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

// [START retail_v2_generated_UserEventService_WriteUserEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\UserEvent;
use Google\Cloud\Retail\V2\UserEventServiceClient;

/**
 * Writes a single user event.
 *
 * @param string $parent             The parent catalog resource name, such as
 *                                   `projects/1234/locations/global/catalogs/default_catalog`.
 * @param string $userEventEventType User event type. Allowed values are:
 *
 *                                   * `add-to-cart`: Products being added to cart.
 *                                   * `category-page-view`: Special pages such as sale or promotion pages
 *                                   viewed.
 *                                   * `detail-page-view`: Products detail page viewed.
 *                                   * `home-page-view`: Homepage viewed.
 *                                   * `promotion-offered`: Promotion is offered to a user.
 *                                   * `promotion-not-offered`: Promotion is not offered to a user.
 *                                   * `purchase-complete`: User finishing a purchase.
 *                                   * `search`: Product search.
 *                                   * `shopping-cart-page-view`: User viewing a shopping cart.
 * @param string $userEventVisitorId A unique identifier for tracking visitors.
 *
 *                                   For example, this could be implemented with an HTTP cookie, which should be
 *                                   able to uniquely identify a visitor on a single device. This unique
 *                                   identifier should not change if the visitor log in/out of the website.
 *
 *                                   Don't set the field to the same fixed ID for different users. This mixes
 *                                   the event history of those users together, which results in degraded model
 *                                   quality.
 *
 *                                   The field must be a UTF-8 encoded string with a length limit of 128
 *                                   characters. Otherwise, an INVALID_ARGUMENT error is returned.
 *
 *                                   The field should not contain PII or user-data. We recommend to use Google
 *                                   Analytics [Client
 *                                   ID](https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#clientId)
 *                                   for this field.
 */
function write_user_event_sample(
    string $parent,
    string $userEventEventType,
    string $userEventVisitorId
): void {
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $userEvent = (new UserEvent())
        ->setEventType($userEventEventType)
        ->setVisitorId($userEventVisitorId);

    // Call the API and handle any network failures.
    try {
        /** @var UserEvent $response */
        $response = $userEventServiceClient->writeUserEvent($parent, $userEvent);
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
    $parent = '[PARENT]';
    $userEventEventType = '[EVENT_TYPE]';
    $userEventVisitorId = '[VISITOR_ID]';

    write_user_event_sample($parent, $userEventEventType, $userEventVisitorId);
}
// [END retail_v2_generated_UserEventService_WriteUserEvent_sync]
