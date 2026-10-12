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

// [START gkehub_v1_generated_GkeHub_CreateScope_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeHub\V1\Client\GkeHubClient;
use Google\Cloud\GkeHub\V1\CreateScopeRequest;
use Google\Cloud\GkeHub\V1\Scope;
use Google\Rpc\Status;

/**
 * Creates a Scope.
 *
 * @param string $formattedParent The parent (project and location) where the Scope will be
 *                                created. Specified in the format `projects/&#42;/locations/*`. Please see
 *                                {@see GkeHubClient::locationName()} for help formatting this field.
 * @param string $scopeId         Client chosen ID for the Scope. `scope_id` must be a
 *                                ????
 */
function create_scope_sample(string $formattedParent, string $scopeId): void
{
    // Create a client.
    $gkeHubClient = new GkeHubClient();

    // Prepare the request message.
    $scope = new Scope();
    $request = (new CreateScopeRequest())
        ->setParent($formattedParent)
        ->setScopeId($scopeId)
        ->setScope($scope);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gkeHubClient->createScope($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Scope $result */
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
    $formattedParent = GkeHubClient::locationName('[PROJECT]', '[LOCATION]');
    $scopeId = '[SCOPE_ID]';

    create_scope_sample($formattedParent, $scopeId);
}
// [END gkehub_v1_generated_GkeHub_CreateScope_sync]
