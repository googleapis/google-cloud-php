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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_FetchConnectedGa4Property_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\FetchConnectedGa4PropertyRequest;
use Google\Analytics\Admin\V1alpha\FetchConnectedGa4PropertyResponse;
use Google\ApiCore\ApiException;

/**
 * Given a specified UA property, looks up the GA4 property connected to it.
 * Note: this cannot be used with GA4 properties.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function fetch_connected_ga4_property_sample(): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $request = new FetchConnectedGa4PropertyRequest();

    // Call the API and handle any network failures.
    try {
        /** @var FetchConnectedGa4PropertyResponse $response */
        $response = $analyticsAdminServiceClient->fetchConnectedGa4Property($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_FetchConnectedGa4Property_sync]
