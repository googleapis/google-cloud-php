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

// [START networksecurity_v1_generated_AddressGroupService_UpdateAddressGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\AddressGroup;
use Google\Cloud\NetworkSecurity\V1\AddressGroup\Type;
use Google\Cloud\NetworkSecurity\V1\Client\AddressGroupServiceClient;
use Google\Cloud\NetworkSecurity\V1\UpdateAddressGroupRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single address group.
 *
 * @param string $addressGroupName     Name of the AddressGroup resource. It matches pattern
 *                                     `projects/&#42;/locations/{location}/addressGroups/<address_group>`.
 * @param int    $addressGroupType     The type of the Address Group. Possible values are "IPv4" or
 *                                     "IPV6".
 * @param int    $addressGroupCapacity Capacity of the Address Group
 */
function update_address_group_sample(
    string $addressGroupName,
    int $addressGroupType,
    int $addressGroupCapacity
): void {
    // Create a client.
    $addressGroupServiceClient = new AddressGroupServiceClient();

    // Prepare the request message.
    $addressGroup = (new AddressGroup())
        ->setName($addressGroupName)
        ->setType($addressGroupType)
        ->setCapacity($addressGroupCapacity);
    $request = (new UpdateAddressGroupRequest())
        ->setAddressGroup($addressGroup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $addressGroupServiceClient->updateAddressGroup($request);
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
    $addressGroupName = '[NAME]';
    $addressGroupType = Type::TYPE_UNSPECIFIED;
    $addressGroupCapacity = 0;

    update_address_group_sample($addressGroupName, $addressGroupType, $addressGroupCapacity);
}
// [END networksecurity_v1_generated_AddressGroupService_UpdateAddressGroup_sync]
