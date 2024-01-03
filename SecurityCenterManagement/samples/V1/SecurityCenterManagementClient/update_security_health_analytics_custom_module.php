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

// [START securitycentermanagement_v1_generated_SecurityCenterManagement_UpdateSecurityHealthAnalyticsCustomModule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenterManagement\V1\Client\SecurityCenterManagementClient;
use Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenterManagement\V1\UpdateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates the SecurityHealthAnalyticsCustomModule under the given name based
 * on the given update mask. Updating the enablement state is supported on
 * both resident and inherited modules (though resident modules cannot have an
 * enablement state of "inherited"). Updating the display name and custom
 * config of a module is supported on resident modules only.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_security_health_analytics_custom_module_sample(): void
{
    // Create a client.
    $securityCenterManagementClient = new SecurityCenterManagementClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
    $request = (new UpdateSecurityHealthAnalyticsCustomModuleRequest())
        ->setUpdateMask($updateMask)
        ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);

    // Call the API and handle any network failures.
    try {
        /** @var SecurityHealthAnalyticsCustomModule $response */
        $response = $securityCenterManagementClient->updateSecurityHealthAnalyticsCustomModule($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END securitycentermanagement_v1_generated_SecurityCenterManagement_UpdateSecurityHealthAnalyticsCustomModule_sync]
