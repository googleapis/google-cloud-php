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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEnhancedMeasurementSettings_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\EnhancedMeasurementSettings;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * Updates the enhanced measurement settings for this data stream.
 * Note that the stream must enable enhanced measurement for these settings to
 * take effect.
 *
 * @param string $enhancedMeasurementSettingsSearchQueryParameter URL query parameters to interpret as site search parameters.
 *                                                                Max length is 1024 characters. Must not be empty.
 */
function update_enhanced_measurement_settings_sample(
    string $enhancedMeasurementSettingsSearchQueryParameter
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $enhancedMeasurementSettings = (new EnhancedMeasurementSettings())
        ->setSearchQueryParameter($enhancedMeasurementSettingsSearchQueryParameter);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var EnhancedMeasurementSettings $response */
        $response = $analyticsAdminServiceClient->updateEnhancedMeasurementSettings(
            $enhancedMeasurementSettings,
            $updateMask
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
    $enhancedMeasurementSettingsSearchQueryParameter = '[SEARCH_QUERY_PARAMETER]';

    update_enhanced_measurement_settings_sample($enhancedMeasurementSettingsSearchQueryParameter);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEnhancedMeasurementSettings_sync]
