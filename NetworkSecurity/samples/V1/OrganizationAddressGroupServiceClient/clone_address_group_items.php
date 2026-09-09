<?php
/*
 * Copyright 2026 Google LLC
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

// [START networksecurity_v1_generated_OrganizationAddressGroupService_CloneAddressGroupItems_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\AddressGroup;
use Google\Cloud\NetworkSecurity\V1\Client\OrganizationAddressGroupServiceClient;
use Google\Cloud\NetworkSecurity\V1\CloneAddressGroupItemsRequest;
use Google\Rpc\Status;

/**
 * Clones items from one address group to another.
 *
 * @param string $formattedAddressGroup       A name of the AddressGroup to clone items to. Must be in the
 *                                            format `projects|organization/&#42;/locations/{location}/addressGroups/*`. Please see
 *                                            {@see OrganizationAddressGroupServiceClient::addressGroupName()} for help formatting this field.
 * @param string $formattedSourceAddressGroup Source address group to clone items from. Please see
 *                                            {@see OrganizationAddressGroupServiceClient::addressGroupName()} for help formatting this field.
 */
function clone_address_group_items_sample(
    string $formattedAddressGroup,
    string $formattedSourceAddressGroup
): void {
    // Create a client.
    $organizationAddressGroupServiceClient = new OrganizationAddressGroupServiceClient();

    // Prepare the request message.
    $request = (new CloneAddressGroupItemsRequest())
        ->setAddressGroup($formattedAddressGroup)
        ->setSourceAddressGroup($formattedSourceAddressGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $organizationAddressGroupServiceClient->cloneAddressGroupItems($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AddressGroup $result */
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
    $formattedAddressGroup = OrganizationAddressGroupServiceClient::addressGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[ADDRESS_GROUP]'
    );
    $formattedSourceAddressGroup = OrganizationAddressGroupServiceClient::addressGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[ADDRESS_GROUP]'
    );

    clone_address_group_items_sample($formattedAddressGroup, $formattedSourceAddressGroup);
}
// [END networksecurity_v1_generated_OrganizationAddressGroupService_CloneAddressGroupItems_sync]
