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

// [START accesscontextmanager_v1_generated_AccessContextManager_CreateGcpUserAccessBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\Client\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\CreateGcpUserAccessBindingRequest;
use Google\Identity\AccessContextManager\V1\GcpUserAccessBinding;
use Google\Rpc\Status;

/**
 * Creates a [GcpUserAccessBinding]
 * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding]. If the
 * client specifies a [name]
 * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding.name],
 * the server ignores it. Fails if a resource already exists with the same
 * [group_key]
 * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding.group_key].
 * Completion of this long-running operation does not necessarily signify that
 * the new binding is deployed onto all affected users, which may take more
 * time.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_gcp_user_access_binding_sample(): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Prepare the request message.
    $request = new CreateGcpUserAccessBindingRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->createGcpUserAccessBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GcpUserAccessBinding $result */
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
// [END accesscontextmanager_v1_generated_AccessContextManager_CreateGcpUserAccessBinding_sync]
