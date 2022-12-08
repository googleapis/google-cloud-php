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

// [START redis_v1_generated_CloudRedis_ImportInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\V1\CloudRedisClient;
use Google\Cloud\Redis\V1\InputConfig;
use Google\Cloud\Redis\V1\Instance;
use Google\Rpc\Status;

/**
 * Import a Redis RDB snapshot file from Cloud Storage into a Redis instance.
 *
 * Redis may stop serving during this operation. Instance state will be
 * IMPORTING for entire operation. When complete, the instance will contain
 * only data from the imported file.
 *
 * The returned operation is automatically deleted after a few hours, so
 * there is no need to call DeleteOperation.
 *
 * @param string $name Redis instance resource name using the form:
 *                     `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *                     where `location_id` refers to a GCP region.
 */
function import_instance_sample(string $name): void
{
    // Create a client.
    $cloudRedisClient = new CloudRedisClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new InputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClient->importInstance($name, $inputConfig);
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
    $name = '[NAME]';

    import_instance_sample($name);
}
// [END redis_v1_generated_CloudRedis_ImportInstance_sync]
