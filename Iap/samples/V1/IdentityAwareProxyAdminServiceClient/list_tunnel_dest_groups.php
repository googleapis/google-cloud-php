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

// [START iap_v1_generated_IdentityAwareProxyAdminService_ListTunnelDestGroups_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Iap\V1\Client\IdentityAwareProxyAdminServiceClient;
use Google\Cloud\Iap\V1\ListTunnelDestGroupsRequest;
use Google\Cloud\Iap\V1\TunnelDestGroup;

/**
 * Lists the existing TunnelDestGroups. To group across all locations, use a
 * `-` as the location ID. For example:
 * `/v1/projects/123/iap_tunnel/locations/-/destGroups`
 *
 * @param string $formattedParent Google Cloud Project ID and location.
 *                                In the following format:
 *                                `projects/{project_number/id}/iap_tunnel/locations/{location}`.
 *                                A `-` can be used for the location to group across all locations. Please see
 *                                {@see IdentityAwareProxyAdminServiceClient::tunnelLocationName()} for help formatting this field.
 */
function list_tunnel_dest_groups_sample(string $formattedParent): void
{
    // Create a client.
    $identityAwareProxyAdminServiceClient = new IdentityAwareProxyAdminServiceClient();

    // Prepare the request message.
    $request = (new ListTunnelDestGroupsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $identityAwareProxyAdminServiceClient->listTunnelDestGroups($request);

        /** @var TunnelDestGroup $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = IdentityAwareProxyAdminServiceClient::tunnelLocationName(
        '[PROJECT]',
        '[LOCATION]'
    );

    list_tunnel_dest_groups_sample($formattedParent);
}
// [END iap_v1_generated_IdentityAwareProxyAdminService_ListTunnelDestGroups_sync]
