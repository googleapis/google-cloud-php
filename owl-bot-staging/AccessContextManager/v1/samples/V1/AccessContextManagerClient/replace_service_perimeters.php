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

// [START accesscontextmanager_v1_generated_AccessContextManager_ReplaceServicePerimeters_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\ReplaceServicePerimetersResponse;
use Google\Identity\AccessContextManager\V1\ServicePerimeter;
use Google\Rpc\Status;

/**
 * Replace all existing [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an [access
 * policy] [google.identity.accesscontextmanager.v1.AccessPolicy] with the
 * [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] provided. This
 * is done atomically. The long-running operation from this RPC has a
 * successful status after all replacements propagate to long-lasting storage.
 * Replacements containing errors result in an error response for the first
 * error encountered. Upon an error, replacement are cancelled and existing
 * [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] are not
 * affected. The Operation.response field contains
 * ReplaceServicePerimetersResponse.
 *
 * @param string $formattedParent Resource name for the access policy which owns these
 *                                [Service Perimeters]
 *                                [google.identity.accesscontextmanager.v1.ServicePerimeter].
 *
 *                                Format: `accessPolicies/{policy_id}`
 *                                Please see {@see AccessContextManagerClient::accessPolicyName()} for help formatting this field.
 */
function replace_service_perimeters_sample(string $formattedParent): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $servicePerimeters = [new ServicePerimeter()];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessContextManagerClient->replaceServicePerimeters(
            $formattedParent,
            $servicePerimeters
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ReplaceServicePerimetersResponse $result */
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

    replace_service_perimeters_sample($formattedParent);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_ReplaceServicePerimeters_sync]
