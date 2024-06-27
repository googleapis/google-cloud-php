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

// [START vmwareengine_v1_generated_VmwareEngine_CreateManagementDnsZoneBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\CreateManagementDnsZoneBindingRequest;
use Google\Cloud\VmwareEngine\V1\ManagementDnsZoneBinding;
use Google\Rpc\Status;

/**
 * Creates a new `ManagementDnsZoneBinding` resource in a private cloud.
 * This RPC creates the DNS binding and the resource that represents the
 * DNS binding of the consumer VPC network to the management DNS zone. A
 * management DNS zone is the Cloud DNS cross-project binding zone that
 * VMware Engine creates for each private cloud. It contains FQDNs and
 * corresponding IP addresses for the private cloud's ESXi hosts and
 * management VM appliances like vCenter and NSX Manager.
 *
 * @param string $formattedParent            The resource name of the private cloud
 *                                           to create a new management DNS zone binding for.
 *                                           Resource names are schemeless URIs that follow the conventions in
 *                                           https://cloud.google.com/apis/design/resource_names.
 *                                           For example:
 *                                           `projects/my-project/locations/us-central1-a/privateClouds/my-cloud`
 *                                           Please see {@see VmwareEngineClient::privateCloudName()} for help formatting this field.
 * @param string $managementDnsZoneBindingId The user-provided identifier of the `ManagementDnsZoneBinding`
 *                                           resource to be created. This identifier must be unique among
 *                                           `ManagementDnsZoneBinding` resources within the parent and becomes the
 *                                           final token in the name URI. The identifier must meet the following
 *                                           requirements:
 *
 *                                           * Only contains 1-63 alphanumeric characters and hyphens
 *                                           * Begins with an alphabetical character
 *                                           * Ends with a non-hyphen character
 *                                           * Not formatted as a UUID
 *                                           * Complies with [RFC 1034](https://datatracker.ietf.org/doc/html/rfc1034)
 *                                           (section 3.5)
 */
function create_management_dns_zone_binding_sample(
    string $formattedParent,
    string $managementDnsZoneBindingId
): void {
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $managementDnsZoneBinding = new ManagementDnsZoneBinding();
    $request = (new CreateManagementDnsZoneBindingRequest())
        ->setParent($formattedParent)
        ->setManagementDnsZoneBinding($managementDnsZoneBinding)
        ->setManagementDnsZoneBindingId($managementDnsZoneBindingId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->createManagementDnsZoneBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ManagementDnsZoneBinding $result */
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
    $formattedParent = VmwareEngineClient::privateCloudName(
        '[PROJECT]',
        '[LOCATION]',
        '[PRIVATE_CLOUD]'
    );
    $managementDnsZoneBindingId = '[MANAGEMENT_DNS_ZONE_BINDING_ID]';

    create_management_dns_zone_binding_sample($formattedParent, $managementDnsZoneBindingId);
}
// [END vmwareengine_v1_generated_VmwareEngine_CreateManagementDnsZoneBinding_sync]
