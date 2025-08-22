<?php
/*
 * Copyright 2025 Google LLC
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

// [START networkservices_v1_generated_NetworkServices_CreateWasmPluginVersion_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateWasmPluginVersionRequest;
use Google\Cloud\NetworkServices\V1\WasmPluginVersion;
use Google\Rpc\Status;

/**
 * Creates a new `WasmPluginVersion` resource in a given project
 * and location.
 *
 * @param string $formattedParent     The parent resource of the `WasmPluginVersion` resource. Must be
 *                                    in the format
 *                                    `projects/{project}/locations/global/wasmPlugins/{wasm_plugin}`. Please see
 *                                    {@see NetworkServicesClient::wasmPluginName()} for help formatting this field.
 * @param string $wasmPluginVersionId User-provided ID of the `WasmPluginVersion` resource to be
 *                                    created.
 */
function create_wasm_plugin_version_sample(
    string $formattedParent,
    string $wasmPluginVersionId
): void {
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $wasmPluginVersion = new WasmPluginVersion();
    $request = (new CreateWasmPluginVersionRequest())
        ->setParent($formattedParent)
        ->setWasmPluginVersionId($wasmPluginVersionId)
        ->setWasmPluginVersion($wasmPluginVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createWasmPluginVersion($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var WasmPluginVersion $result */
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
    $formattedParent = NetworkServicesClient::wasmPluginName(
        '[PROJECT]',
        '[LOCATION]',
        '[WASM_PLUGIN]'
    );
    $wasmPluginVersionId = '[WASM_PLUGIN_VERSION_ID]';

    create_wasm_plugin_version_sample($formattedParent, $wasmPluginVersionId);
}
// [END networkservices_v1_generated_NetworkServices_CreateWasmPluginVersion_sync]
