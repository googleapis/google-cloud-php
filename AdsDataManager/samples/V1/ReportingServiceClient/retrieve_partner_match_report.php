<?php
/*
 * Copyright 2026 Google LLC
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

// [START datamanager_v1_generated_ReportingService_RetrievePartnerMatchReport_sync]
use Google\Ads\DataManager\V1\Client\ReportingServiceClient;
use Google\Ads\DataManager\V1\PartnerMatchReportEntry;
use Google\Ads\DataManager\V1\RetrievePartnerMatchReportRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Retrieves a partner match report.
 *
 * This feature is only available to data partners.
 *
 * @param string $parent    The parent account that owns the user list.
 *                          Format: `accountTypes/{account_type}/accounts/{account}`
 * @param int    $startDate The start date (inclusive) of the report data to retrieve.  Only
 *                          data from the last 2 years can be retrieved.  If the start date is set to
 *                          an older date, only data from the last 2 years will be returned. Should be
 *                          in the format YYYYMMDD.
 */
function retrieve_partner_match_report_sample(string $parent, int $startDate): void
{
    // Create a client.
    $reportingServiceClient = new ReportingServiceClient();

    // Prepare the request message.
    $request = (new RetrievePartnerMatchReportRequest())
        ->setParent($parent)
        ->setStartDate($startDate);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $reportingServiceClient->retrievePartnerMatchReport($request);

        /** @var PartnerMatchReportEntry $element */
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
    $parent = '[PARENT]';
    $startDate = 0;

    retrieve_partner_match_report_sample($parent, $startDate);
}
// [END datamanager_v1_generated_ReportingService_RetrievePartnerMatchReport_sync]
