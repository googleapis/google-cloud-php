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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetRecurringAudienceList_sync]
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\GetRecurringAudienceListRequest;
use Google\Analytics\Data\V1alpha\RecurringAudienceList;
use Google\ApiCore\ApiException;

/**
 * Gets configuration metadata about a specific recurring audience list. This
 * method can be used to understand a recurring audience list's state after it
 * has been created. For example, a recurring audience list resource will
 * generate audience list instances for each day, and this method can be used
 * to get the resource name of the most recent audience list instance.
 *
 * This method is introduced at alpha stability with the intention of
 * gathering feedback on syntax and capabilities before entering beta. To give
 * your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $formattedName The recurring audience list resource name.
 *                              Format:
 *                              `properties/{property}/recurringAudienceLists/{recurring_audience_list}`
 *                              Please see {@see AlphaAnalyticsDataClient::recurringAudienceListName()} for help formatting this field.
 */
function get_recurring_audience_list_sample(string $formattedName): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new GetRecurringAudienceListRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var RecurringAudienceList $response */
        $response = $alphaAnalyticsDataClient->getRecurringAudienceList($request);
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
    $formattedName = AlphaAnalyticsDataClient::recurringAudienceListName(
        '[PROPERTY]',
        '[RECURRING_AUDIENCE_LIST]'
    );

    get_recurring_audience_list_sample($formattedName);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_GetRecurringAudienceList_sync]
