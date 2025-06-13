<?php
/*
 * Copyright 2025 Google LLC
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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateSubpropertySyncConfig_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\SubpropertySyncConfig;
use Google\Analytics\Admin\V1alpha\SubpropertySyncConfig\SynchronizationMode;
use Google\Analytics\Admin\V1alpha\UpdateSubpropertySyncConfigRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a Subproperty Sync Config.
 *
 * @param int $subpropertySyncConfigCustomDimensionAndMetricSyncMode Specifies the Custom Dimension / Metric synchronization mode for
 *                                                                   the Subproperty.
 *
 *                                                                   If set to ALL, Custom Dimension / Metric synchronization will be
 *                                                                   immediately enabled.  Local configuration of Custom Dimensions / Metrics
 *                                                                   will not be allowed on the Subproperty so long as the synchronization mode
 *                                                                   is set to ALL.
 *
 *                                                                   If set to NONE, Custom Dimensions / Metric synchronization is disabled.
 *                                                                   Custom Dimensions / Metrics must be configured explicitly on the
 *                                                                   Subproperty.
 */
function update_subproperty_sync_config_sample(
    int $subpropertySyncConfigCustomDimensionAndMetricSyncMode
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $subpropertySyncConfig = (new SubpropertySyncConfig())
        ->setCustomDimensionAndMetricSyncMode($subpropertySyncConfigCustomDimensionAndMetricSyncMode);
    $request = (new UpdateSubpropertySyncConfigRequest())
        ->setSubpropertySyncConfig($subpropertySyncConfig);

    // Call the API and handle any network failures.
    try {
        /** @var SubpropertySyncConfig $response */
        $response = $analyticsAdminServiceClient->updateSubpropertySyncConfig($request);
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
    $subpropertySyncConfigCustomDimensionAndMetricSyncMode = SynchronizationMode::SYNCHRONIZATION_MODE_UNSPECIFIED;

    update_subproperty_sync_config_sample($subpropertySyncConfigCustomDimensionAndMetricSyncMode);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateSubpropertySyncConfig_sync]
