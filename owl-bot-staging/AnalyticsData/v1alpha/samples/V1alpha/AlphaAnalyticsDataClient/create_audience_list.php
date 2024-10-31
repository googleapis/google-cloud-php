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

// [START analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateAudienceList_sync]
use Google\Analytics\Data\V1alpha\AudienceDimension;
use Google\Analytics\Data\V1alpha\AudienceList;
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\CreateAudienceListRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Rpc\Status;

/**
 * Creates an audience list for later retrieval. This method quickly returns
 * the audience list's resource name and initiates a long running asynchronous
 * request to form an audience list. To list the users in an audience list,
 * first create the audience list through this method and then send the
 * audience resource name to the `QueryAudienceList` method.
 *
 * See [Creating an Audience
 * List](https://developers.google.com/analytics/devguides/reporting/data/v1/audience-list-basics)
 * for an introduction to Audience Lists with examples.
 *
 * An audience list is a snapshot of the users currently in the audience at
 * the time of audience list creation. Creating audience lists for one
 * audience on different days will return different results as users enter and
 * exit the audience.
 *
 * Audiences in Google Analytics 4 allow you to segment your users in the ways
 * that are important to your business. To learn more, see
 * https://support.google.com/analytics/answer/9267572. Audience lists contain
 * the users in each audience.
 *
 * This method is available at beta stability at
 * [audienceExports.create](https://developers.google.com/analytics/devguides/reporting/data/v1/rest/v1beta/properties.audienceExports/create).
 * To give your feedback on this API, complete the [Google Analytics Audience
 * Export API Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $formattedParent      The parent resource where this audience list will be created.
 *                                     Format: `properties/{property}`
 *                                     Please see {@see AlphaAnalyticsDataClient::propertyName()} for help formatting this field.
 * @param string $audienceListAudience The audience resource name. This resource name identifies the
 *                                     audience being listed and is shared between the Analytics Data & Admin
 *                                     APIs.
 *
 *                                     Format: `properties/{property}/audiences/{audience}`
 */
function create_audience_list_sample(string $formattedParent, string $audienceListAudience): void
{
    // Create a client.
    $alphaAnalyticsDataClient = new AlphaAnalyticsDataClient();

    // Prepare the request message.
    $audienceListDimensions = [new AudienceDimension()];
    $audienceList = (new AudienceList())
        ->setAudience($audienceListAudience)
        ->setDimensions($audienceListDimensions);
    $request = (new CreateAudienceListRequest())
        ->setParent($formattedParent)
        ->setAudienceList($audienceList);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alphaAnalyticsDataClient->createAudienceList($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AudienceList $result */
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
    $formattedParent = AlphaAnalyticsDataClient::propertyName('[PROPERTY]');
    $audienceListAudience = '[AUDIENCE]';

    create_audience_list_sample($formattedParent, $audienceListAudience);
}
// [END analyticsdata_v1alpha_generated_AlphaAnalyticsData_CreateAudienceList_sync]
