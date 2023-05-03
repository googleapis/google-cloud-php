<?php
/*
 * Copyright 2022 Google LLC
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

// [START memcache_v1beta2_generated_CloudMemcache_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memcache\V1beta2\CloudMemcacheClient;
use Google\Cloud\Memcache\V1beta2\Instance;
use Google\Cloud\Memcache\V1beta2\Instance\NodeConfig;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an existing Instance in a given project and location.
 *
 * @param string $resourceName                   Unique name of the resource in this scope including project and
 *                                               location using the form:
 *                                               `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *
 *                                               Note: Memcached instances are managed and addressed at the regional level
 *                                               so `location_id` here refers to a Google Cloud region; however, users may
 *                                               choose which zones Memcached nodes should be provisioned in within an
 *                                               instance. Refer to [zones][google.cloud.memcache.v1beta2.Instance.zones] field for more details.
 * @param int    $resourceNodeCount              Number of nodes in the Memcached instance.
 * @param int    $resourceNodeConfigCpuCount     Number of cpus per Memcached node.
 * @param int    $resourceNodeConfigMemorySizeMb Memory size in MiB for each Memcached node.
 */
function update_instance_sample(
    string $resourceName,
    int $resourceNodeCount,
    int $resourceNodeConfigCpuCount,
    int $resourceNodeConfigMemorySizeMb
): void {
    // Create a client.
    $cloudMemcacheClient = new CloudMemcacheClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $resourceNodeConfig = (new NodeConfig())
        ->setCpuCount($resourceNodeConfigCpuCount)
        ->setMemorySizeMb($resourceNodeConfigMemorySizeMb);
    $resource = (new Instance())
        ->setName($resourceName)
        ->setNodeCount($resourceNodeCount)
        ->setNodeConfig($resourceNodeConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudMemcacheClient->updateInstance($updateMask, $resource);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $resourceName = '[NAME]';
    $resourceNodeCount = 0;
    $resourceNodeConfigCpuCount = 0;
    $resourceNodeConfigMemorySizeMb = 0;

    update_instance_sample(
        $resourceName,
        $resourceNodeCount,
        $resourceNodeConfigCpuCount,
        $resourceNodeConfigMemorySizeMb
    );
}
// [END memcache_v1beta2_generated_CloudMemcache_UpdateInstance_sync]
