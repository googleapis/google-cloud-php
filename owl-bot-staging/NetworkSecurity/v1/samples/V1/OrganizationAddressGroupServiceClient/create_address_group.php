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

// [START networksecurity_v1_generated_OrganizationAddressGroupService_CreateAddressGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\AddressGroup;
use Google\Cloud\NetworkSecurity\V1\AddressGroup\Type;
use Google\Cloud\NetworkSecurity\V1\Client\OrganizationAddressGroupServiceClient;
use Google\Cloud\NetworkSecurity\V1\CreateAddressGroupRequest;
use Google\Rpc\Status;

/**
 * Creates a new address group in a given project and location.
 *
 * @param string $formattedParent      The parent resource of the AddressGroup. Must be in the
 *                                     format `projects/&#42;/locations/{location}`. Please see
 *                                     {@see OrganizationAddressGroupServiceClient::organizationLocationName()} for help formatting this field.
 * @param string $addressGroupId       Short name of the AddressGroup resource to be created.
 *                                     This value should be 1-63 characters long, containing only
 *                                     letters, numbers, hyphens, and underscores, and should not start
 *                                     with a number. E.g. "authz_policy".
 * @param string $addressGroupName     Name of the AddressGroup resource. It matches pattern
 *                                     `projects/&#42;/locations/{location}/addressGroups/<address_group>`.
 * @param int    $addressGroupType     The type of the Address Group. Possible values are "IPv4" or
 *                                     "IPV6".
 * @param int    $addressGroupCapacity Capacity of the Address Group
 */
function create_address_group_sample(
    string $formattedParent,
    string $addressGroupId,
    string $addressGroupName,
    int $addressGroupType,
    int $addressGroupCapacity
): void {
    // Create a client.
    $organizationAddressGroupServiceClient = new OrganizationAddressGroupServiceClient();

    // Prepare the request message.
    $addressGroup = (new AddressGroup())
        ->setName($addressGroupName)
        ->setType($addressGroupType)
        ->setCapacity($addressGroupCapacity);
    $request = (new CreateAddressGroupRequest())
        ->setParent($formattedParent)
        ->setAddressGroupId($addressGroupId)
        ->setAddressGroup($addressGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $organizationAddressGroupServiceClient->createAddressGroup($request);
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
    $formattedParent = OrganizationAddressGroupServiceClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );
    $addressGroupId = '[ADDRESS_GROUP_ID]';
    $addressGroupName = '[NAME]';
    $addressGroupType = Type::TYPE_UNSPECIFIED;
    $addressGroupCapacity = 0;

    create_address_group_sample(
        $formattedParent,
        $addressGroupId,
        $addressGroupName,
        $addressGroupType,
        $addressGroupCapacity
    );
}
// [END networksecurity_v1_generated_OrganizationAddressGroupService_CreateAddressGroup_sync]
