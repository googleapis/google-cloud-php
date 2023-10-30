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

// [START securitycenter_v1_generated_SecurityCenter_GetEffectiveSecurityHealthAnalyticsCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\EffectiveSecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/**
 * Retrieves an EffectiveSecurityHealthAnalyticsCustomModule.
 *
 * @param string $formattedName Name of the effective custom module to get. Its format is
 *                              "organizations/{organization}/securityHealthAnalyticsSettings/effectiveCustomModules/{customModule}",
 *                              "folders/{folder}/securityHealthAnalyticsSettings/effectiveCustomModules/{customModule}",
 *                              or
 *                              "projects/{project}/securityHealthAnalyticsSettings/effectiveCustomModules/{customModule}"
 *                              Please see {@see SecurityCenterClient::effectiveSecurityHealthAnalyticsCustomModuleName()} for help formatting this field.
 */
function get_effective_security_health_analytics_custom_module_sample(string $formattedName): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Call the API and handle any network failures.
    try {
        /** @var EffectiveSecurityHealthAnalyticsCustomModule $response */
        $response = $securityCenterClient->getEffectiveSecurityHealthAnalyticsCustomModule($formattedName);
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
    $formattedName = SecurityCenterClient::effectiveSecurityHealthAnalyticsCustomModuleName(
        '[ORGANIZATION]',
        '[EFFECTIVE_CUSTOM_MODULE]'
    );

    get_effective_security_health_analytics_custom_module_sample($formattedName);
}
// [END securitycenter_v1_generated_SecurityCenter_GetEffectiveSecurityHealthAnalyticsCustomModule_sync]
