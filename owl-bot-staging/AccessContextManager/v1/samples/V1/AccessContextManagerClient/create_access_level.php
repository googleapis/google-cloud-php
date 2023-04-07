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

// [START accesscontextmanager_v1_generated_AccessContextManager_CreateAccessLevel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\AccessLevel;
use Google\Rpc\Status;

/**
 * Creates an [access level]
 * [google.identity.accesscontextmanager.v1.AccessLevel]. The long-running
 * operation from this RPC has a successful status after the [access
 * level] [google.identity.accesscontextmanager.v1.AccessLevel]
 * propagates to long-lasting storage. If [access levels]
 * [google.identity.accesscontextmanager.v1.AccessLevel] contain
 * errors, an error response is returned for the first error encountered.
 *
 * @param string $formattedParent Resource name for the access policy which owns this [Access
 *                                Level] [google.identity.accesscontextmanager.v1.AccessLevel].
 *
 *                                Format: `accessPolicies/{policy_id}`
 *                                Please see {@see AccessContextManagerClient::accessPolicyName()} for help formatting this field.
 */
function create_access_level_sample(string $formattedParent): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $accessLevel = new AccessLevel();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->createAccessLevel($formattedParent, $accessLevel);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AccessLevel $result */
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
    $formattedParent = AccessContextManagerClient::accessPolicyName('[ACCESS_POLICY]');

    create_access_level_sample($formattedParent);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_CreateAccessLevel_sync]
