<?php
/*
 * Copyright 2024 Google LLC
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

// [START redis_v1_generated_CloudRedis_UpdateInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\V1\CloudRedisClient;
use Google\Cloud\Redis\V1\Instance;
use Google\Cloud\Redis\V1\Instance\Tier;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the metadata and configuration of a specific Redis instance.
 *
 * Completed longrunning.Operation will contain the new instance object
 * in the response field. The returned operation is automatically deleted
 * after a few hours, so there is no need to call DeleteOperation.
 *
 * @param string $instanceName         Unique name of the resource in this scope including project and
 *                                     location using the form:
 *                                     `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *
 *                                     Note: Redis instances are managed and addressed at regional level so
 *                                     location_id here refers to a GCP region; however, users may choose which
 *                                     specific zone (or collection of zones for cross-zone instances) an instance
 *                                     should be provisioned in. Refer to
 *                                     [location_id][google.cloud.redis.v1.Instance.location_id] and
 *                                     [alternative_location_id][google.cloud.redis.v1.Instance.alternative_location_id]
 *                                     fields for more details.
 * @param int    $instanceTier         The service tier of the instance.
 * @param int    $instanceMemorySizeGb Redis memory size in GiB.
 */
function update_instance_sample(
    string $instanceName,
    int $instanceTier,
    int $instanceMemorySizeGb
): void {
    // Create a client.
    $cloudRedisClient = new CloudRedisClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $updateMask = new FieldMask();
    $instance = (new Instance())
        ->setName($instanceName)
        ->setTier($instanceTier)
        ->setMemorySizeGb($instanceMemorySizeGb);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClient->updateInstance($updateMask, $instance);
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
    $instanceName = '[NAME]';
    $instanceTier = Tier::TIER_UNSPECIFIED;
    $instanceMemorySizeGb = 0;

    update_instance_sample($instanceName, $instanceTier, $instanceMemorySizeGb);
}
// [END redis_v1_generated_CloudRedis_UpdateInstance_sync]
