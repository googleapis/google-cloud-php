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

// [START accesscontextmanager_v1_generated_AccessContextManager_CommitServicePerimeters_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\CommitServicePerimetersResponse;
use Google\Rpc\Status;

/**
 * Commits the dry-run specification for all the [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an
 * [access policy][google.identity.accesscontextmanager.v1.AccessPolicy].
 * A commit operation on a service perimeter involves copying its `spec` field
 * to the `status` field of the service perimeter. Only [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] with
 * `use_explicit_dry_run_spec` field set to true are affected by a commit
 * operation. The long-running operation from this RPC has a successful
 * status after the dry-run specifications for all the [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] have been
 * committed. If a commit fails, it causes the long-running operation to
 * return an error response and the entire commit operation is cancelled.
 * When successful, the Operation.response field contains
 * CommitServicePerimetersResponse. The `dry_run` and the `spec` fields are
 * cleared after a successful commit operation.
 *
 * @param string $formattedParent Resource name for the parent [Access Policy]
 *                                [google.identity.accesscontextmanager.v1.AccessPolicy] which owns all
 *                                [Service Perimeters]
 *                                [google.identity.accesscontextmanager.v1.ServicePerimeter] in scope for
 *                                the commit operation.
 *
 *                                Format: `accessPolicies/{policy_id}`
 *                                Please see {@see AccessContextManagerClient::accessPolicyName()} for help formatting this field.
 */
function commit_service_perimeters_sample(string $formattedParent): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->commitServicePerimeters($formattedParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CommitServicePerimetersResponse $result */
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

    commit_service_perimeters_sample($formattedParent);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_CommitServicePerimeters_sync]
