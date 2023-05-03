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

// [START memcache_v1_generated_CloudMemcache_CreateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memcache\V1\CloudMemcacheClient;
use Google\Cloud\Memcache\V1\Instance;
use Google\Cloud\Memcache\V1\Instance\NodeConfig;
use Google\Rpc\Status;

/**
 * Creates a new Instance in a given location.
 *
 * @param string $formattedParent                The resource name of the instance location using the form:
 *                                               `projects/{project_id}/locations/{location_id}`
 *                                               where `location_id` refers to a GCP region
 *                                               Please see {@see CloudMemcacheClient::locationName()} for help formatting this field.
 * @param string $instanceId                     The logical name of the Memcached instance in the user
 *                                               project with the following restrictions:
 *
 *                                               * Must contain only lowercase letters, numbers, and hyphens.
 *                                               * Must start with a letter.
 *                                               * Must be between 1-40 characters.
 *                                               * Must end with a number or a letter.
 *                                               * Must be unique within the user project / location.
 *
 *                                               If any of the above are not met, the API raises an invalid argument error.
 * @param string $instanceName                   Unique name of the resource in this scope including project and
 *                                               location using the form:
 *                                               `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *
 *                                               Note: Memcached instances are managed and addressed at the regional level
 *                                               so `location_id` here refers to a Google Cloud region; however, users may
 *                                               choose which zones Memcached nodes should be provisioned in within an
 *                                               instance. Refer to [zones][google.cloud.memcache.v1.Instance.zones] field for more details.
 * @param int    $instanceNodeCount              Number of nodes in the Memcached instance.
 * @param int    $instanceNodeConfigCpuCount     Number of cpus per Memcached node.
 * @param int    $instanceNodeConfigMemorySizeMb Memory size in MiB for each Memcached node.
 */
function create_instance_sample(
    string $formattedParent,
    string $instanceId,
    string $instanceName,
    int $instanceNodeCount,
    int $instanceNodeConfigCpuCount,
    int $instanceNodeConfigMemorySizeMb
): void {
    // Create a client.
    $cloudMemcacheClient = new CloudMemcacheClient();

    // Prepare the request message.
    $instanceNodeConfig = (new NodeConfig())
        ->setCpuCount($instanceNodeConfigCpuCount)
        ->setMemorySizeMb($instanceNodeConfigMemorySizeMb);
    $instance = (new Instance())
        ->setName($instanceName)
        ->setNodeCount($instanceNodeCount)
        ->setNodeConfig($instanceNodeConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudMemcacheClient->createInstance($formattedParent, $instanceId, $instance);
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
    $formattedParent = CloudMemcacheClient::locationName('[PROJECT]', '[LOCATION]');
    $instanceId = '[INSTANCE_ID]';
    $instanceName = '[NAME]';
    $instanceNodeCount = 0;
    $instanceNodeConfigCpuCount = 0;
    $instanceNodeConfigMemorySizeMb = 0;

    create_instance_sample(
        $formattedParent,
        $instanceId,
        $instanceName,
        $instanceNodeCount,
        $instanceNodeConfigCpuCount,
        $instanceNodeConfigMemorySizeMb
    );
}
// [END memcache_v1_generated_CloudMemcache_CreateInstance_sync]
