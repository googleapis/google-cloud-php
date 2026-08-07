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

// [START netapp_v1_generated_NetApp_CreateHostGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateHostGroupRequest;
use Google\Cloud\NetApp\V1\HostGroup;
use Google\Cloud\NetApp\V1\HostGroup\Type;
use Google\Cloud\NetApp\V1\OsType;
use Google\Rpc\Status;

/**
 * Creates a new host group.
 *
 * @param string $formattedParent       Parent value for CreateHostGroupRequest
 *                                      Please see {@see NetAppClient::locationName()} for help formatting this field.
 * @param int    $hostGroupType         Type of the host group.
 * @param string $hostGroupHostsElement The list of hosts associated with the host group.
 * @param int    $hostGroupOsType       The OS type of the host group. It indicates the type of operating
 *                                      system used by all of the hosts in the HostGroup. All hosts in a HostGroup
 *                                      must be of the same OS type. This can be set only when creating a
 *                                      HostGroup.
 * @param string $hostGroupId           ID of the host group to create. Must be unique within the parent
 *                                      resource. Must contain only letters, numbers, and hyphen, with
 *                                      the first character a letter or underscore, the last a letter or underscore
 *                                      or a number, and a 63 character maximum.
 */
function create_host_group_sample(
    string $formattedParent,
    int $hostGroupType,
    string $hostGroupHostsElement,
    int $hostGroupOsType,
    string $hostGroupId
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $hostGroupHosts = [$hostGroupHostsElement,];
    $hostGroup = (new HostGroup())
        ->setType($hostGroupType)
        ->setHosts($hostGroupHosts)
        ->setOsType($hostGroupOsType);
    $request = (new CreateHostGroupRequest())
        ->setParent($formattedParent)
        ->setHostGroup($hostGroup)
        ->setHostGroupId($hostGroupId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createHostGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var HostGroup $result */
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
    $formattedParent = NetAppClient::locationName('[PROJECT]', '[LOCATION]');
    $hostGroupType = Type::TYPE_UNSPECIFIED;
    $hostGroupHostsElement = '[HOSTS]';
    $hostGroupOsType = OsType::OS_TYPE_UNSPECIFIED;
    $hostGroupId = '[HOST_GROUP_ID]';

    create_host_group_sample(
        $formattedParent,
        $hostGroupType,
        $hostGroupHostsElement,
        $hostGroupOsType,
        $hostGroupId
    );
}
// [END netapp_v1_generated_NetApp_CreateHostGroup_sync]
