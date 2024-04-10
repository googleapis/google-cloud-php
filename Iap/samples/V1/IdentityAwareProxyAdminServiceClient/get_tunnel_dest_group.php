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

// [START iap_v1_generated_IdentityAwareProxyAdminService_GetTunnelDestGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iap\V1\Client\IdentityAwareProxyAdminServiceClient;
use Google\Cloud\Iap\V1\GetTunnelDestGroupRequest;
use Google\Cloud\Iap\V1\TunnelDestGroup;

/**
 * Retrieves an existing TunnelDestGroup.
 *
 * @param string $formattedName Name of the TunnelDestGroup to be fetched.
 *                              In the following format:
 *                              `projects/{project_number/id}/iap_tunnel/locations/{location}/destGroups/{dest_group}`. Please see
 *                              {@see IdentityAwareProxyAdminServiceClient::tunnelDestGroupName()} for help formatting this field.
 */
function get_tunnel_dest_group_sample(string $formattedName): void
{
    // Create a client.
    $identityAwareProxyAdminServiceClient = new IdentityAwareProxyAdminServiceClient();

    // Prepare the request message.
    $request = (new GetTunnelDestGroupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var TunnelDestGroup $response */
        $response = $identityAwareProxyAdminServiceClient->getTunnelDestGroup($request);
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
    $formattedName = IdentityAwareProxyAdminServiceClient::tunnelDestGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[DEST_GROUP]'
    );

    get_tunnel_dest_group_sample($formattedName);
}
// [END iap_v1_generated_IdentityAwareProxyAdminService_GetTunnelDestGroup_sync]
