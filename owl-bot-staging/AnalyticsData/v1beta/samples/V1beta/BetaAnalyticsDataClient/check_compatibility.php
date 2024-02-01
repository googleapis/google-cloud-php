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

// [START analyticsdata_v1beta_generated_BetaAnalyticsData_CheckCompatibility_sync]
use Google\Analytics\Data\V1beta\CheckCompatibilityRequest;
use Google\Analytics\Data\V1beta\CheckCompatibilityResponse;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\ApiCore\ApiException;

/**
 * This compatibility method lists dimensions and metrics that can be added to
 * a report request and maintain compatibility. This method fails if the
 * request's dimensions and metrics are incompatible.
 *
 * In Google Analytics, reports fail if they request incompatible dimensions
 * and/or metrics; in that case, you will need to remove dimensions and/or
 * metrics from the incompatible report until the report is compatible.
 *
 * The Realtime and Core reports have different compatibility rules. This
 * method checks compatibility for Core reports.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function check_compatibility_sample(): void
{
    // Create a client.
    $betaAnalyticsDataClient = new BetaAnalyticsDataClient();

    // Prepare the request message.
    $request = new CheckCompatibilityRequest();

    // Call the API and handle any network failures.
    try {
        /** @var CheckCompatibilityResponse $response */
        $response = $betaAnalyticsDataClient->checkCompatibility($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsdata_v1beta_generated_BetaAnalyticsData_CheckCompatibility_sync]
