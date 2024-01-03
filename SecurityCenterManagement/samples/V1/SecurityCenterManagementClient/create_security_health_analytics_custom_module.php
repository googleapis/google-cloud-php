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

// [START securitycentermanagement_v1_generated_SecurityCenterManagement_CreateSecurityHealthAnalyticsCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenterManagement\V1\Client\SecurityCenterManagementClient;
use Google\Cloud\SecurityCenterManagement\V1\CreateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule;

/**
 * Creates a resident SecurityHealthAnalyticsCustomModule at the scope of the
 * given CRM parent, and also creates inherited
 * SecurityHealthAnalyticsCustomModules for all CRM descendants of the given
 * parent. These modules are enabled by default.
 *
 * @param string $formattedParent Name of the parent for the module. Its format is
 *                                "organizations/{organization}/locations/{location}",
 *                                "folders/{folder}/locations/{location}",
 *                                or
 *                                "projects/{project}/locations/{location}"
 *                                Please see {@see SecurityCenterManagementClient::organizationLocationName()} for help formatting this field.
 */
function create_security_health_analytics_custom_module_sample(string $formattedParent): void
{
    // Create a client.
    $securityCenterManagementClient = new SecurityCenterManagementClient();

    // Prepare the request message.
    $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
    $request = (new CreateSecurityHealthAnalyticsCustomModuleRequest())
        ->setParent($formattedParent)
        ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);

    // Call the API and handle any network failures.
    try {
        /** @var SecurityHealthAnalyticsCustomModule $response */
        $response = $securityCenterManagementClient->createSecurityHealthAnalyticsCustomModule($request);
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
    $formattedParent = SecurityCenterManagementClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );

    create_security_health_analytics_custom_module_sample($formattedParent);
}
// [END securitycentermanagement_v1_generated_SecurityCenterManagement_CreateSecurityHealthAnalyticsCustomModule_sync]
