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

// [START redis_v1_generated_CloudRedis_RescheduleMaintenance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\V1\Client\CloudRedisClient;
use Google\Cloud\Redis\V1\Instance;
use Google\Cloud\Redis\V1\RescheduleMaintenanceRequest;
use Google\Cloud\Redis\V1\RescheduleMaintenanceRequest\RescheduleType;
use Google\Rpc\Status;

/**
 * Reschedule maintenance for a given instance in a given project and
 * location.
 *
 * @param string $formattedName  Redis instance resource name using the form:
 *                               `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *                               where `location_id` refers to a GCP region. Please see
 *                               {@see CloudRedisClient::instanceName()} for help formatting this field.
 * @param int    $rescheduleType If reschedule type is SPECIFIC_TIME, must set up schedule_time as
 *                               well.
 */
function reschedule_maintenance_sample(string $formattedName, int $rescheduleType): void
{
    // Create a client.
    $cloudRedisClient = new CloudRedisClient();

    // Prepare the request message.
    $request = (new RescheduleMaintenanceRequest())
        ->setName($formattedName)
        ->setRescheduleType($rescheduleType);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClient->rescheduleMaintenance($request);
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
    $rescheduleType = RescheduleType::RESCHEDULE_TYPE_UNSPECIFIED;

    reschedule_maintenance_sample($formattedName, $rescheduleType);
}
// [END redis_v1_generated_CloudRedis_RescheduleMaintenance_sync]
