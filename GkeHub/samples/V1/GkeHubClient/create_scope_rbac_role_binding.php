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

// [START gkehub_v1_generated_GkeHub_CreateScopeRBACRoleBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeHub\V1\Client\GkeHubClient;
use Google\Cloud\GkeHub\V1\CreateScopeRBACRoleBindingRequest;
use Google\Cloud\GkeHub\V1\RBACRoleBinding;
use Google\Cloud\GkeHub\V1\RBACRoleBinding\Role;
use Google\Rpc\Status;

/**
 * Creates a Scope RBACRoleBinding.
 *
 * @param string $formattedParent   The parent (project and location) where the RBACRoleBinding will
 *                                  be created. Specified in the format `projects/&#42;/locations/&#42;/scopes/*`. Please see
 *                                  {@see GkeHubClient::scopeName()} for help formatting this field.
 * @param string $rbacrolebindingId Client chosen ID for the RBACRoleBinding. `rbacrolebinding_id`
 *                                  must be a valid RFC 1123 compliant DNS label:
 *
 *                                  1. At most 63 characters in length
 *                                  2. It must consist of lower case alphanumeric characters or `-`
 *                                  3. It must start and end with an alphanumeric character
 *
 *                                  Which can be expressed as the regex: `[a-z0-9]([-a-z0-9]*[a-z0-9])?`,
 *                                  with a maximum length of 63 characters.
 */
function create_scope_rbac_role_binding_sample(
    string $formattedParent,
    string $rbacrolebindingId
): void {
    // Create a client.
    $gkeHubClient = new GkeHubClient();

    // Prepare the request message.
    $rbacrolebindingRole = new Role();
    $rbacrolebinding = (new RBACRoleBinding())
        ->setRole($rbacrolebindingRole);
    $request = (new CreateScopeRBACRoleBindingRequest())
        ->setParent($formattedParent)
        ->setRbacrolebindingId($rbacrolebindingId)
        ->setRbacrolebinding($rbacrolebinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gkeHubClient->createScopeRBACRoleBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RBACRoleBinding $result */
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
    $formattedParent = GkeHubClient::scopeName('[PROJECT]', '[LOCATION]', '[SCOPE]');
    $rbacrolebindingId = '[RBACROLEBINDING_ID]';

    create_scope_rbac_role_binding_sample($formattedParent, $rbacrolebindingId);
}
// [END gkehub_v1_generated_GkeHub_CreateScopeRBACRoleBinding_sync]
