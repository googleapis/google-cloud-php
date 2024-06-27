<?php
/*
 * Copyright 2024 Google LLC
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

// [START vmwareengine_v1_generated_VmwareEngine_GetDnsBindPermission_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\DnsBindPermission;
use Google\Cloud\VmwareEngine\V1\GetDnsBindPermissionRequest;

/**
 * Gets all the principals having bind permission on the intranet VPC
 * associated with the consumer project granted by the Grant API.
 * DnsBindPermission is a global resource and location can only be global.
 *
 * @param string $formattedName The name of the resource which stores the users/service accounts
 *                              having the permission to bind to the corresponding intranet VPC of the
 *                              consumer project. DnsBindPermission is a global resource. Resource names
 *                              are schemeless URIs that follow the conventions in
 *                              https://cloud.google.com/apis/design/resource_names. For example:
 *                              `projects/my-project/locations/global/dnsBindPermission`
 *                              Please see {@see VmwareEngineClient::dnsBindPermissionName()} for help formatting this field.
 */
function get_dns_bind_permission_sample(string $formattedName): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $request = (new GetDnsBindPermissionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DnsBindPermission $response */
        $response = $vmwareEngineClient->getDnsBindPermission($request);
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
    $formattedName = VmwareEngineClient::dnsBindPermissionName('[PROJECT]', '[LOCATION]');

    get_dns_bind_permission_sample($formattedName);
}
// [END vmwareengine_v1_generated_VmwareEngine_GetDnsBindPermission_sync]
