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

// [START privilegedaccessmanager_v1_generated_PrivilegedAccessManager_RevokeGrant_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\PrivilegedAccessManager\V1\Client\PrivilegedAccessManagerClient;
use Google\Cloud\PrivilegedAccessManager\V1\Grant;
use Google\Cloud\PrivilegedAccessManager\V1\RevokeGrantRequest;
use Google\Rpc\Status;

/**
 * `RevokeGrant` is used to immediately revoke access for a grant. This method
 * can be called when the grant is in a non-terminal state.
 *
 * @param string $formattedName Name of the grant resource which is being revoked. Please see
 *                              {@see PrivilegedAccessManagerClient::grantName()} for help formatting this field.
 */
function revoke_grant_sample(string $formattedName): void
{
    // Create a client.
    $privilegedAccessManagerClient = new PrivilegedAccessManagerClient();

    // Prepare the request message.
    $request = (new RevokeGrantRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $privilegedAccessManagerClient->revokeGrant($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Grant $result */
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
    $formattedName = PrivilegedAccessManagerClient::grantName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTITLEMENT]',
        '[GRANT]'
    );

    revoke_grant_sample($formattedName);
}
// [END privilegedaccessmanager_v1_generated_PrivilegedAccessManager_RevokeGrant_sync]
