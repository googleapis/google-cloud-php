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

// [START securitycenter_v1_generated_SecurityCenter_CreateSecurityHealthAnalyticsCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\SecurityHealthAnalyticsCustomModule;

/**
 * Creates a resident SecurityHealthAnalyticsCustomModule at the scope of the
 * given CRM parent, and also creates inherited
 * SecurityHealthAnalyticsCustomModules for all CRM descendants of the given
 * parent. These modules are enabled by default.
 *
 * @param string $formattedParent Resource name of the new custom module's parent. Its format is
 *                                "organizations/{organization}/securityHealthAnalyticsSettings",
 *                                "folders/{folder}/securityHealthAnalyticsSettings", or
 *                                "projects/{project}/securityHealthAnalyticsSettings"
 *                                Please see {@see SecurityCenterClient::securityHealthAnalyticsSettingsName()} for help formatting this field.
 */
function create_security_health_analytics_custom_module_sample(string $formattedParent): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();

    // Call the API and handle any network failures.
    try {
        /** @var SecurityHealthAnalyticsCustomModule $response */
        $response = $securityCenterClient->createSecurityHealthAnalyticsCustomModule(
            $formattedParent,
            $securityHealthAnalyticsCustomModule
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
    $formattedParent = SecurityCenterClient::securityHealthAnalyticsSettingsName('[ORGANIZATION]');

    create_security_health_analytics_custom_module_sample($formattedParent);
}
// [END securitycenter_v1_generated_SecurityCenter_CreateSecurityHealthAnalyticsCustomModule_sync]
