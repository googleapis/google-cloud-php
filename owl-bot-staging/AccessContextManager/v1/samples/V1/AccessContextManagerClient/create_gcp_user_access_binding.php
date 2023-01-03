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

// [START accesscontextmanager_v1_generated_AccessContextManager_CreateGcpUserAccessBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
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
 * @param string $formattedParent                                  Example: "organizations/256"
 *                                                                 Please see {@see AccessContextManagerClient::organizationName()} for help formatting this field.
 * @param string $gcpUserAccessBindingGroupKey                     Immutable. Google Group id whose members are subject to this binding's restrictions.
 *                                                                 See "id" in the [G Suite Directory API's Groups resource]
 *                                                                 (https://developers.google.com/admin-sdk/directory/v1/reference/groups#resource).
 *                                                                 If a group's email address/alias is changed, this resource will continue
 *                                                                 to point at the changed group. This field does not accept group email
 *                                                                 addresses or aliases.
 *                                                                 Example: "01d520gv4vjcrht"
 * @param string $formattedGcpUserAccessBindingAccessLevelsElement Access level that a user must have to be granted access. Only one access
 *                                                                 level is supported, not multiple. This repeated field must have exactly
 *                                                                 one element.
 *                                                                 Example: "accessPolicies/9522/accessLevels/device_trusted"
 *                                                                 Please see {@see AccessContextManagerClient::accessLevelName()} for help formatting this field.
 */
function create_gcp_user_access_binding_sample(
    string $formattedParent,
    string $gcpUserAccessBindingGroupKey,
    string $formattedGcpUserAccessBindingAccessLevelsElement
): void {
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedGcpUserAccessBindingAccessLevels = [
        $formattedGcpUserAccessBindingAccessLevelsElement,
    ];
    $gcpUserAccessBinding = (new GcpUserAccessBinding())
        ->setGroupKey($gcpUserAccessBindingGroupKey)
        ->setAccessLevels($formattedGcpUserAccessBindingAccessLevels);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->createGcpUserAccessBinding(
            $formattedParent,
            $gcpUserAccessBinding
        );
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
    $formattedParent = AccessContextManagerClient::organizationName('[ORGANIZATION]');
    $gcpUserAccessBindingGroupKey = '[GROUP_KEY]';
    $formattedGcpUserAccessBindingAccessLevelsElement = AccessContextManagerClient::accessLevelName(
        '[ACCESS_POLICY]',
        '[ACCESS_LEVEL]'
    );

    create_gcp_user_access_binding_sample(
        $formattedParent,
        $gcpUserAccessBindingGroupKey,
        $formattedGcpUserAccessBindingAccessLevelsElement
    );
}
// [END accesscontextmanager_v1_generated_AccessContextManager_CreateGcpUserAccessBinding_sync]
