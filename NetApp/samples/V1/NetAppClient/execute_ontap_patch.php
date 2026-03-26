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

// [START netapp_v1_generated_NetApp_ExecuteOntapPatch_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\ExecuteOntapPatchRequest;
use Google\Cloud\NetApp\V1\ExecuteOntapPatchResponse;
use Google\Protobuf\Struct;

/**
 * `ExecuteOntapPatch` dispatches the ONTAP `PATCH` request to the
 * `StoragePool` cluster.
 *
 * @param string $ontapPath The resource path of the ONTAP resource.
 *                          Format:
 *                          `projects/{project_number}/locations/{location_id}/storagePools/{storage_pool_id}/ontap/{ontap_resource_path}`.
 *                          For example:
 *                          `projects/123456789/locations/us-central1/storagePools/my-storage-pool/ontap/api/storage/volumes`.
 */
function execute_ontap_patch_sample(string $ontapPath): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $body = new Struct();
    $request = (new ExecuteOntapPatchRequest())
        ->setBody($body)
        ->setOntapPath($ontapPath);

    // Call the API and handle any network failures.
    try {
        /** @var ExecuteOntapPatchResponse $response */
        $response = $netAppClient->executeOntapPatch($request);
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
    $ontapPath = '[ONTAP_PATH]';

    execute_ontap_patch_sample($ontapPath);
}
// [END netapp_v1_generated_NetApp_ExecuteOntapPatch_sync]
