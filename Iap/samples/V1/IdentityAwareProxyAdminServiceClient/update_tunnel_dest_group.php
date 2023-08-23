<?php
/*
 * Copyright 2022 Google LLC
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

// [START iap_v1_generated_IdentityAwareProxyAdminService_UpdateTunnelDestGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iap\V1\IdentityAwareProxyAdminServiceClient;
use Google\Cloud\Iap\V1\TunnelDestGroup;

/**
 * Updates a TunnelDestGroup.
 *
 * @param string $tunnelDestGroupName Immutable. Identifier for the TunnelDestGroup. Must be unique
 *                                    within the project and contain only lower case letters (a-z) and dashes
 *                                    (-).
 */
function update_tunnel_dest_group_sample(string $tunnelDestGroupName): void
{
    // Create a client.
    $identityAwareProxyAdminServiceClient = new IdentityAwareProxyAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $tunnelDestGroup = (new TunnelDestGroup())
        ->setName($tunnelDestGroupName);

    // Call the API and handle any network failures.
    try {
        /** @var TunnelDestGroup $response */
        $response = $identityAwareProxyAdminServiceClient->updateTunnelDestGroup($tunnelDestGroup);
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
    $tunnelDestGroupName = '[NAME]';

    update_tunnel_dest_group_sample($tunnelDestGroupName);
}
// [END iap_v1_generated_IdentityAwareProxyAdminService_UpdateTunnelDestGroup_sync]
