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

// [START discoveryengine_v1_generated_UserEventService_ImportUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\UserEventServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsRequest;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsRequest\InlineSource;
use Google\Cloud\DiscoveryEngine\V1\ImportUserEventsResponse;
use Google\Cloud\DiscoveryEngine\V1\UserEvent;
use Google\Rpc\Status;

/**
 * Bulk import of User events. Request processing might be
 * synchronous. Events that already exist are skipped.
 * Use this method for backfilling historical user events.
 *
 * Operation.response is of type ImportResponse. Note that it is
 * possible for a subset of the items to be successfully inserted.
 * Operation.metadata is of type ImportMetadata.
 *
 * @param string $inlineSourceUserEventsEventType    User event type. Allowed values are:
 *
 *                                                   Generic values:
 *
 *                                                   * `search`: Search for Documents.
 *                                                   * `view-item`: Detailed page view of a Document.
 *                                                   * `view-item-list`: View of a panel or ordered list of Documents.
 *                                                   * `view-home-page`: View of the home page.
 *                                                   * `view-category-page`: View of a category page, e.g. Home > Men > Jeans
 *
 *                                                   Retail-related values:
 *
 *                                                   * `add-to-cart`: Add an item(s) to cart, e.g. in Retail online shopping
 *                                                   * `purchase`: Purchase an item(s)
 *
 *                                                   Media-related values:
 *
 *                                                   * `media-play`: Start/resume watching a video, playing a song, etc.
 *                                                   * `media-complete`: Finished or stopped midway through a video, song, etc.
 * @param string $inlineSourceUserEventsUserPseudoId A unique identifier for tracking visitors.
 *
 *                                                   For example, this could be implemented with an HTTP cookie, which should be
 *                                                   able to uniquely identify a visitor on a single device. This unique
 *                                                   identifier should not change if the visitor log in/out of the website.
 *
 *                                                   Do not set the field to the same fixed ID for different users. This mixes
 *                                                   the event history of those users together, which results in degraded model
 *                                                   quality.
 *
 *                                                   The field must be a UTF-8 encoded string with a length limit of 128
 *                                                   characters. Otherwise, an INVALID_ARGUMENT error is returned.
 *
 *                                                   The field should not contain PII or user-data. We recommend to use Google
 *                                                   Analytics [Client
 *                                                   ID](https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#clientId)
 *                                                   for this field.
 * @param string $formattedParent                    Parent DataStore resource name, of the form
 *                                                   `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}`
 *                                                   Please see {@see UserEventServiceClient::dataStoreName()} for help formatting this field.
 */
function import_user_events_sample(
    string $inlineSourceUserEventsEventType,
    string $inlineSourceUserEventsUserPseudoId,
    string $formattedParent
): void {
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare the request message.
    $userEvent = (new UserEvent())
        ->setEventType($inlineSourceUserEventsEventType)
        ->setUserPseudoId($inlineSourceUserEventsUserPseudoId);
    $inlineSourceUserEvents = [$userEvent,];
    $inlineSource = (new InlineSource())
        ->setUserEvents($inlineSourceUserEvents);
    $request = (new ImportUserEventsRequest())
        ->setInlineSource($inlineSource)
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $userEventServiceClient->importUserEvents($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportUserEventsResponse $result */
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
    $inlineSourceUserEventsEventType = '[EVENT_TYPE]';
    $inlineSourceUserEventsUserPseudoId = '[USER_PSEUDO_ID]';
    $formattedParent = UserEventServiceClient::dataStoreName('[PROJECT]', '[LOCATION]', '[DATA_STORE]');

    import_user_events_sample(
        $inlineSourceUserEventsEventType,
        $inlineSourceUserEventsUserPseudoId,
        $formattedParent
    );
}
// [END discoveryengine_v1_generated_UserEventService_ImportUserEvents_sync]
