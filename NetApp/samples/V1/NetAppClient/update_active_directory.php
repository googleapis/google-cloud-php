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

// [START netapp_v1_generated_NetApp_UpdateActiveDirectory_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\ActiveDirectory;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\UpdateActiveDirectoryRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update the parameters of an active directories.
 *
 * @param string $activeDirectoryDomain        Name of the Active Directory domain
 * @param string $activeDirectoryDns           Comma separated list of DNS server IP addresses for the Active
 *                                             Directory domain.
 * @param string $activeDirectoryNetBiosPrefix NetBIOSPrefix is used as a prefix for SMB server name.
 * @param string $activeDirectoryUsername      Username of the Active Directory domain administrator.
 * @param string $activeDirectoryPassword      Password of the Active Directory domain administrator.
 */
function update_active_directory_sample(
    string $activeDirectoryDomain,
    string $activeDirectoryDns,
    string $activeDirectoryNetBiosPrefix,
    string $activeDirectoryUsername,
    string $activeDirectoryPassword
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $activeDirectory = (new ActiveDirectory())
        ->setDomain($activeDirectoryDomain)
        ->setDns($activeDirectoryDns)
        ->setNetBiosPrefix($activeDirectoryNetBiosPrefix)
        ->setUsername($activeDirectoryUsername)
        ->setPassword($activeDirectoryPassword);
    $request = (new UpdateActiveDirectoryRequest())
        ->setUpdateMask($updateMask)
        ->setActiveDirectory($activeDirectory);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->updateActiveDirectory($request);
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
    $activeDirectoryDomain = '[DOMAIN]';
    $activeDirectoryDns = '[DNS]';
    $activeDirectoryNetBiosPrefix = '[NET_BIOS_PREFIX]';
    $activeDirectoryUsername = '[USERNAME]';
    $activeDirectoryPassword = '[PASSWORD]';

    update_active_directory_sample(
        $activeDirectoryDomain,
        $activeDirectoryDns,
        $activeDirectoryNetBiosPrefix,
        $activeDirectoryUsername,
        $activeDirectoryPassword
    );
}
// [END netapp_v1_generated_NetApp_UpdateActiveDirectory_sync]
