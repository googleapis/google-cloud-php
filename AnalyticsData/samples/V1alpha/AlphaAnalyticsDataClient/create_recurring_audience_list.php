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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateRecurringAudienceList_sync]
use Google\Analytics\Data\V1alpha\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\AudienceDimension;
use Google\Analytics\Data\V1alpha\RecurringAudienceList;
use Google\ApiCore\ApiException;

/**
 * Creates a recurring audience list. Recurring audience lists produces new
 * audience lists each day. Audience lists are users in an audience at the
 * time of the list's creation.
 *
 * A recurring audience list ensures that you have audience list based on the
 * most recent data available for use each day. If you manually create
 * audience list, you don't know when an audience list based on an additional
 * day's data is available. This recurring audience list automates the
 * creation of an audience list when an additional day's data is available.
 * You will consume fewer quota tokens by using recurring audience list versus
 * manually creating audience list at various times of day trying to guess
 * when an additional day's data is ready.
 *
 * This method is introduced at alpha stability with the intention of
 * gathering feedback on syntax and capabilities before entering beta. To give
 * your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $formattedParent               The parent resource where this recurring audience list will be
 *                                              created. Format: `properties/{property}`
 *                                              Please see {@see AlphaAnalyticsDataClient::propertyName()} for help formatting this field.
 * @param string $recurringAudienceListAudience The audience resource name. This resource name identifies the
 *                                              audience being listed and is shared between the Analytics Data & Admin
 *                                              APIs.
 *
 *                                              Format: `properties/{property}/audiences/{audience}`
 */
function create_recurring_audience_list_sample(
    string $formattedParent,
    string $recurringAudienceListAudience
): void {
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $recurringAudienceListDimensions = [new AudienceDimension()];
    $recurringAudienceList = (new RecurringAudienceList())
        ->setAudience($recurringAudienceListAudience)
        ->setDimensions($recurringAudienceListDimensions);

    // Call the API and handle any network failures.
    try {
        /** @var RecurringAudienceList $response */
        $response = $alphaAnalyticsDataClient->createRecurringAudienceList(
            $formattedParent,
            $recurringAudienceList
        );
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
    $formattedParent = AlphaAnalyticsDataClient::propertyName('[PROPERTY]');
    $recurringAudienceListAudience = '[AUDIENCE]';

    create_recurring_audience_list_sample($formattedParent, $recurringAudienceListAudience);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateRecurringAudienceList_sync]
