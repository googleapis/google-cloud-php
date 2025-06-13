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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_GetSubpropertySyncConfig_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\GetSubpropertySyncConfigRequest;
use Google\Analytics\Admin\V1alpha\SubpropertySyncConfig;
use Google\ApiCore\ApiException;

/**
 * Lookup for a single Subproperty Sync Config.
 *
 * @param string $formattedName Resource name of the SubpropertySyncConfig to lookup.
 *                              Format:
 *                              properties/{ordinary_property_id}/subpropertySyncConfigs/{subproperty_id}
 *                              Example: properties/1234/subpropertySyncConfigs/5678
 *                              Please see {@see AnalyticsAdminServiceClient::subpropertySyncConfigName()} for help formatting this field.
 */
function get_subproperty_sync_config_sample(string $formattedName): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $request = (new GetSubpropertySyncConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SubpropertySyncConfig $response */
        $response = $analyticsAdminServiceClient->getSubpropertySyncConfig($request);
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
    $formattedName = AnalyticsAdminServiceClient::subpropertySyncConfigName(
        '[PROPERTY]',
        '[SUBPROPERTY_SYNC_CONFIG]'
    );

    get_subproperty_sync_config_sample($formattedName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_GetSubpropertySyncConfig_sync]
