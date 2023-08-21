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

// [START notebooks_v1_generated_ManagedNotebookService_RefreshRuntimeTokenInternal_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Notebooks\V1\Client\ManagedNotebookServiceClient;
use Google\Cloud\Notebooks\V1\RefreshRuntimeTokenInternalRequest;
use Google\Cloud\Notebooks\V1\RefreshRuntimeTokenInternalResponse;

/**
 * Gets an access token for the consumer service account that the customer
 * attached to the runtime. Only accessible from the tenant instance.
 *
 * @param string $formattedName Format:
 *                              `projects/{project_id}/locations/{location}/runtimes/{runtime_id}`
 *                              Please see {@see ManagedNotebookServiceClient::runtimeName()} for help formatting this field.
 * @param string $vmId          The VM hardware token for authenticating the VM.
 *                              https://cloud.google.com/compute/docs/instances/verifying-instance-identity
 */
function refresh_runtime_token_internal_sample(string $formattedName, string $vmId): void
{
    // Create a client.
    $managedNotebookServiceClient = new ManagedNotebookServiceClient();

    // Prepare the request message.
    $request = (new RefreshRuntimeTokenInternalRequest())
        ->setName($formattedName)
        ->setVmId($vmId);

    // Call the API and handle any network failures.
    try {
        /** @var RefreshRuntimeTokenInternalResponse $response */
        $response = $managedNotebookServiceClient->refreshRuntimeTokenInternal($request);
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
    $formattedName = ManagedNotebookServiceClient::runtimeName('[PROJECT]', '[LOCATION]', '[RUNTIME]');
    $vmId = '[VM_ID]';

    refresh_runtime_token_internal_sample($formattedName, $vmId);
}
// [END notebooks_v1_generated_ManagedNotebookService_RefreshRuntimeTokenInternal_sync]
