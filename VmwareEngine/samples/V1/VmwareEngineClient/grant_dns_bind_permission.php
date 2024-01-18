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

// [START vmwareengine_v1_generated_VmwareEngine_GrantDnsBindPermission_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\DnsBindPermission;
use Google\Cloud\VmwareEngine\V1\GrantDnsBindPermissionRequest;
use Google\Cloud\VmwareEngine\V1\Principal;
use Google\Rpc\Status;

/**
 * Grants the bind permission to the customer provided principal(user /
 * service account) to bind their DNS zone with the intranet VPC associated
 * with the project. DnsBindPermission is a global resource and location can
 * only be global.
 *
 * @param string $formattedName The name of the resource which stores the users/service accounts
 *                              having the permission to bind to the corresponding intranet VPC of the
 *                              consumer project. DnsBindPermission is a global resource. Resource names
 *                              are schemeless URIs that follow the conventions in
 *                              https://cloud.google.com/apis/design/resource_names. For example:
 *                              `projects/my-project/locations/global/dnsBindPermission`
 *                              Please see {@see VmwareEngineClient::dnsBindPermissionName()} for help formatting this field.
 */
function grant_dns_bind_permission_sample(string $formattedName): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $principal = new Principal();
    $request = (new GrantDnsBindPermissionRequest())
        ->setName($formattedName)
        ->setPrincipal($principal);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->grantDnsBindPermission($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DnsBindPermission $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedName = VmwareEngineClient::dnsBindPermissionName('[PROJECT]', '[LOCATION]');

    grant_dns_bind_permission_sample($formattedName);
}
// [END vmwareengine_v1_generated_VmwareEngine_GrantDnsBindPermission_sync]
