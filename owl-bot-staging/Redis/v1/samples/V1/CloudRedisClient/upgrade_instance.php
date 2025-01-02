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

// [START redis_v1_generated_CloudRedis_UpgradeInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\V1\Client\CloudRedisClient;
use Google\Cloud\Redis\V1\Instance;
use Google\Cloud\Redis\V1\UpgradeInstanceRequest;
use Google\Rpc\Status;

/**
 * Upgrades Redis instance to the newer Redis version specified in the
 * request.
 *
 * @param string $formattedName Redis instance resource name using the form:
 *                              `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *                              where `location_id` refers to a GCP region. Please see
 *                              {@see CloudRedisClient::instanceName()} for help formatting this field.
 * @param string $redisVersion  Specifies the target version of Redis software to upgrade to.
 */
function upgrade_instance_sample(string $formattedName, string $redisVersion): void
{
    // Create a client.
    $cloudRedisClient = new CloudRedisClient();

    // Prepare the request message.
    $request = (new UpgradeInstanceRequest())
        ->setName($formattedName)
        ->setRedisVersion($redisVersion);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClient->upgradeInstance($request);
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
    $formattedName = CloudRedisClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $redisVersion = '[REDIS_VERSION]';

    upgrade_instance_sample($formattedName, $redisVersion);
}
// [END redis_v1_generated_CloudRedis_UpgradeInstance_sync]
