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

// [START monitoring_v3_generated_QueryService_QueryTimeSeries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Monitoring\V3\Client\QueryServiceClient;
use Google\Cloud\Monitoring\V3\QueryTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\TimeSeriesData;

/**
 * Queries time series by using Monitoring Query Language (MQL). We recommend
 * using PromQL instead of MQL. For more information about the status of MQL,
 * see the [MQL deprecation
 * notice](https://cloud.google.com/stackdriver/docs/deprecations/mql).
 *
 * @param string $name  The
 *                      [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
 *                      to execute the request. The format is:
 *
 *                      projects/[PROJECT_ID_OR_NUMBER]
 * @param string $query The query in the [Monitoring Query
 *                      Language](https://cloud.google.com/monitoring/mql/reference) format.
 *                      The default time zone is in UTC.
 */
function query_time_series_sample(string $name, string $query): void
{
    // Create a client.
    $queryServiceClient = new QueryServiceClient();

    // Prepare the request message.
    $request = (new QueryTimeSeriesRequest())
        ->setName($name)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $queryServiceClient->queryTimeSeries($request);

        /** @var TimeSeriesData $element */
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
    $name = '[NAME]';
    $query = '[QUERY]';

    query_time_series_sample($name, $query);
}
// [END monitoring_v3_generated_QueryService_QueryTimeSeries_sync]
