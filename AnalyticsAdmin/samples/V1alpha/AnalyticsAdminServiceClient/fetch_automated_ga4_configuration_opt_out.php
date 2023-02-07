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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_FetchAutomatedGa4ConfigurationOptOut_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\FetchAutomatedGa4ConfigurationOptOutResponse;
use Google\ApiCore\ApiException;

/**
 * Fetches the opt out status for the automated GA4 setup process for a UA
 * property.
 * Note: this has no effect on GA4 property.
 *
 * @param string $property The UA property to get the opt out status. Note this request uses
 *                         the internal property ID, not the tracking ID of the form UA-XXXXXX-YY.
 *                         Format: properties/{internalWebPropertyId}
 *                         Example: properties/1234
 */
function fetch_automated_ga4_configuration_opt_out_sample(string $property): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var FetchAutomatedGa4ConfigurationOptOutResponse $response */
        $response = $analyticsAdminServiceClient->fetchAutomatedGa4ConfigurationOptOut($property);
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
    $property = '[PROPERTY]';

    fetch_automated_ga4_configuration_opt_out_sample($property);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_FetchAutomatedGa4ConfigurationOptOut_sync]
