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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_QueryAudienceExport_sync]
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\QueryAudienceExportRequest;
use Google\Analytics\Data\V1beta\QueryAudienceExportResponse;
use Google\ApiCore\ApiException;

/**
 * Retrieves an audience export of users. After creating an audience, the
 * users are not immediately available for exporting. First, a request to
 * `CreateAudienceExport` is necessary to create an audience export of users,
 * and then second, this method is used to retrieve the users in the audience
 * export.
 *
 * See [Creating an Audience
 * Export](https://developers.google.com/analytics/devguides/reporting/data/v1/audience-list-basics)
 * for an introduction to Audience Exports with examples.
 *
 * Audiences in Google Analytics 4 allow you to segment your users in the ways
 * that are important to your business. To learn more, see
 * https://support.google.com/analytics/answer/9267572.
 *
 * Audience Export APIs have some methods at alpha and other methods at beta
 * stability. The intention is to advance methods to beta stability after some
 * feedback and adoption. To give your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * @param string $name The name of the audience export to retrieve users from.
 *                     Format: `properties/{property}/audienceExports/{audience_export}`
 */
function query_audience_export_sample(string $name): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $request = (new QueryAudienceExportRequest())
        ->setName($name);

    // Call the API and handle any network failures.
    try {
        /** @var QueryAudienceExportResponse $response */
        $response = $betaAnalyticsDataClient->queryAudienceExport($request);
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
    $name = '[NAME]';

    query_audience_export_sample($name);
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_QueryAudienceExport_sync]
