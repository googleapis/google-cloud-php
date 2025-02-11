<?php
/*
 * Copyright 2023 Google LLC
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

// [START netapp_v1_generated_NetApp_CreateActiveDirectory_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\ActiveDirectory;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateActiveDirectoryRequest;
use Google\Rpc\Status;

/**
 * CreateActiveDirectory
 * Creates the active directory specified in the request.
 *
 * @param string $formattedParent              Value for parent. Please see
 *                                             {@see NetAppClient::locationName()} for help formatting this field.
 * @param string $activeDirectoryDomain        Name of the Active Directory domain
 * @param string $activeDirectoryDns           Comma separated list of DNS server IP addresses for the Active
 *                                             Directory domain.
 * @param string $activeDirectoryNetBiosPrefix NetBIOSPrefix is used as a prefix for SMB server name.
 * @param string $activeDirectoryUsername      Username of the Active Directory domain administrator.
 * @param string $activeDirectoryPassword      Password of the Active Directory domain administrator.
 * @param string $activeDirectoryId            ID of the active directory to create. Must be unique within the
 *                                             parent resource. Must contain only letters, numbers and hyphen, with the
 *                                             first character a letter , the last a letter or a number, and a 63
 *                                             character maximum.
 */
function create_active_directory_sample(
    string $formattedParent,
    string $activeDirectoryDomain,
    string $activeDirectoryDns,
    string $activeDirectoryNetBiosPrefix,
    string $activeDirectoryUsername,
    string $activeDirectoryPassword,
    string $activeDirectoryId
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $activeDirectory = (new ActiveDirectory())
        ->setDomain($activeDirectoryDomain)
        ->setDns($activeDirectoryDns)
        ->setNetBiosPrefix($activeDirectoryNetBiosPrefix)
        ->setUsername($activeDirectoryUsername)
        ->setPassword($activeDirectoryPassword);
    $request = (new CreateActiveDirectoryRequest())
        ->setParent($formattedParent)
        ->setActiveDirectory($activeDirectory)
        ->setActiveDirectoryId($activeDirectoryId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createActiveDirectory($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ActiveDirectory $result */
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
    $activeDirectoryDomain = '[DOMAIN]';
    $activeDirectoryDns = '[DNS]';
    $activeDirectoryNetBiosPrefix = '[NET_BIOS_PREFIX]';
    $activeDirectoryUsername = '[USERNAME]';
    $activeDirectoryPassword = '[PASSWORD]';
    $activeDirectoryId = '[ACTIVE_DIRECTORY_ID]';

    create_active_directory_sample(
        $formattedParent,
        $activeDirectoryDomain,
        $activeDirectoryDns,
        $activeDirectoryNetBiosPrefix,
        $activeDirectoryUsername,
        $activeDirectoryPassword,
        $activeDirectoryId
    );
}
// [END netapp_v1_generated_NetApp_CreateActiveDirectory_sync]
