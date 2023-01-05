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

// [START accesscontextmanager_v1_generated_AccessContextManager_GetGcpUserAccessBinding_sync]
use Google\ApiCore\ApiException;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\GcpUserAccessBinding;

/**
 * Gets the [GcpUserAccessBinding]
 * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding] with
 * the given name.
 *
 * @param string $formattedName Example: "organizations/256/gcpUserAccessBindings/b3-BhcX_Ud5N"
 *                              Please see {@see AccessContextManagerClient::gcpUserAccessBindingName()} for help formatting this field.
 */
function get_gcp_user_access_binding_sample(string $formattedName): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var GcpUserAccessBinding $response */
        $response = $accessContextManagerClient->getGcpUserAccessBinding($formattedName);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = AccessContextManagerClient::gcpUserAccessBindingName(
        '[ORGANIZATION]',
        '[GCP_USER_ACCESS_BINDING]'
    );

    get_gcp_user_access_binding_sample($formattedName);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_GetGcpUserAccessBinding_sync]
