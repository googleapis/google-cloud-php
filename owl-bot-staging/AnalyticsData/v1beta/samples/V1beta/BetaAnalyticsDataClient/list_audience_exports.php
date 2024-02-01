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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_ListAudienceExports_sync]
use Google\Analytics\Data\V1beta\AudienceExport;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\ListAudienceExportsRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Lists all audience exports for a property. This method can be used for you
 * to find and reuse existing audience exports rather than creating
 * unnecessary new audience exports. The same audience can have multiple
 * audience exports that represent the export of users that were in an
 * audience on different days.
 *
 * See [Creating an Audience
 * Export](https://developers.google.com/analytics/devguides/reporting/data/v1/audience-list-basics)
 * for an introduction to Audience Exports with examples.
 *
 * Audience Export APIs have some methods at alpha and other methods at beta
 * stability. The intention is to advance methods to beta stability after some
 * feedback and adoption. To give your feedback on this API, complete the
 * [Google Analytics Audience Export API
 * Feedback](https://forms.gle/EeA5u5LW6PEggtCEA) form.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_audience_exports_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $request = new ListAudienceExportsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $betaAnalyticsDataClient->listAudienceExports($request);

        /** @var AudienceExport $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_ListAudienceExports_sync]
