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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateAttributionSettings_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\AttributionSettings;
use Google\Analytics\Admin\V1alpha\AttributionSettings\AcquisitionConversionEventLookbackWindow;
use Google\Analytics\Admin\V1alpha\AttributionSettings\OtherConversionEventLookbackWindow;
use Google\Analytics\Admin\V1alpha\AttributionSettings\ReportingAttributionModel;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * Updates attribution settings on a property.
 *
 * @param int $attributionSettingsAcquisitionConversionEventLookbackWindow The lookback window configuration for acquisition conversion
 *                                                                         events. The default window size is 30 days.
 * @param int $attributionSettingsOtherConversionEventLookbackWindow       The lookback window for all other, non-acquisition conversion
 *                                                                         events. The default window size is 90 days.
 * @param int $attributionSettingsReportingAttributionModel                The reporting attribution model used to calculate conversion
 *                                                                         credit in this property's reports.
 *
 *                                                                         Changing the attribution model will apply to both historical and future
 *                                                                         data. These changes will be reflected in reports with conversion and
 *                                                                         revenue data. User and session data will be unaffected.
 */
function update_attribution_settings_sample(
    int $attributionSettingsAcquisitionConversionEventLookbackWindow,
    int $attributionSettingsOtherConversionEventLookbackWindow,
    int $attributionSettingsReportingAttributionModel
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $attributionSettings = (new AttributionSettings())
        ->setAcquisitionConversionEventLookbackWindow(
            $attributionSettingsAcquisitionConversionEventLookbackWindow
        )
        ->setOtherConversionEventLookbackWindow($attributionSettingsOtherConversionEventLookbackWindow)
        ->setReportingAttributionModel($attributionSettingsReportingAttributionModel);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var AttributionSettings $response */
        $response = $analyticsAdminServiceClient->updateAttributionSettings(
            $attributionSettings,
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
    $attributionSettingsAcquisitionConversionEventLookbackWindow = AcquisitionConversionEventLookbackWindow::ACQUISITION_CONVERSION_EVENT_LOOKBACK_WINDOW_UNSPECIFIED;
    $attributionSettingsOtherConversionEventLookbackWindow = OtherConversionEventLookbackWindow::OTHER_CONVERSION_EVENT_LOOKBACK_WINDOW_UNSPECIFIED;
    $attributionSettingsReportingAttributionModel = ReportingAttributionModel::REPORTING_ATTRIBUTION_MODEL_UNSPECIFIED;

    update_attribution_settings_sample(
        $attributionSettingsAcquisitionConversionEventLookbackWindow,
        $attributionSettingsOtherConversionEventLookbackWindow,
        $attributionSettingsReportingAttributionModel
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateAttributionSettings_sync]
