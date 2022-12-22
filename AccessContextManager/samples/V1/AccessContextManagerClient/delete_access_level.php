<?php
/*
 * Copyright 2022 Google LLC
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

// [START accesscontextmanager_v1_generated_AccessContextManager_DeleteAccessLevel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Rpc\Status;

/**
 * Deletes an [access level]
 * [google.identity.accesscontextmanager.v1.AccessLevel] based on the resource
 * name. The long-running operation from this RPC has a successful status
 * after the [access level]
 * [google.identity.accesscontextmanager.v1.AccessLevel] has been removed
 * from long-lasting storage.
 *
 * @param string $formattedName Resource name for the [Access Level]
 *                              [google.identity.accesscontextmanager.v1.AccessLevel].
 *
 *                              Format:
 *                              `accessPolicies/{policy_id}/accessLevels/{access_level_id}`
 *                              Please see {@see AccessContextManagerClient::accessLevelName()} for help formatting this field.
 */
function delete_access_level_sample(string $formattedName): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->deleteAccessLevel($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = AccessContextManagerClient::accessLevelName('[ACCESS_POLICY]', '[ACCESS_LEVEL]');

    delete_access_level_sample($formattedName);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_DeleteAccessLevel_sync]
