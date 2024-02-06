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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_ListRecurringAudienceLists_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\ListRecurringAudienceListsRequest;
use Google\Analytics\Data\V1alpha\RecurringAudienceList;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Lists all recurring audience lists for a property. This method can be used
 * for you to find and reuse existing recurring audience lists rather than
 * creating unnecessary new recurring audience lists. The same audience can
 * have multiple recurring audience lists that represent different dimension
 * combinations; for example, just the dimension `deviceId` or both the
 * dimensions `deviceId` and `userId`.
 *
 * This method is introduced at alpha stability with the intention of
 * gathering feedback on syntax and capabilities before entering beta. To give
 * your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $formattedParent All recurring audience lists for this property will be listed in
 *                                the response. Format: `properties/{property}`
 *                                Please see {@see AlphaAnalyticsDataClient::propertyName()} for help formatting this field.
 */
function list_recurring_audience_lists_sample(string $formattedParent): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new ListRecurringAudienceListsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $alphaAnalyticsDataClient->listRecurringAudienceLists($request);

        /** @var RecurringAudienceList $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = AlphaAnalyticsDataClient::propertyName('[PROPERTY]');

    list_recurring_audience_lists_sample($formattedParent);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_ListRecurringAudienceLists_sync]
