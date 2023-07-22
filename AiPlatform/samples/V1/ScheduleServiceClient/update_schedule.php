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

// [START aiplatform_v1_generated_ScheduleService_UpdateSchedule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\ScheduleServiceClient;
use Google\Cloud\AIPlatform\V1\Schedule;
use Google\Cloud\AIPlatform\V1\UpdateScheduleRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates an active or paused Schedule.
 *
 * When the Schedule is updated, new runs will be scheduled starting from the
 * updated next execution time after the update time based on the
 * time_specification in the updated Schedule. All unstarted runs before the
 * update time will be skipped while already created runs will NOT be paused
 * or canceled.
 *
 * @param string $scheduleDisplayName           User provided name of the Schedule.
 *                                              The name can be up to 128 characters long and can consist of any UTF-8
 *                                              characters.
 * @param int    $scheduleMaxConcurrentRunCount Maximum number of runs that can be started concurrently for this
 *                                              Schedule. This is the limit for starting the scheduled requests and not the
 *                                              execution of the operations/jobs created by the requests (if applicable).
 */
function update_schedule_sample(
    string $scheduleDisplayName,
    int $scheduleMaxConcurrentRunCount
): void {
    // Create a client.
    $scheduleServiceClient = new ScheduleServiceClient();

    // Prepare the request message.
    $schedule = (new Schedule())
        ->setDisplayName($scheduleDisplayName)
        ->setMaxConcurrentRunCount($scheduleMaxConcurrentRunCount);
    $updateMask = new FieldMask();
    $request = (new UpdateScheduleRequest())
        ->setSchedule($schedule)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Schedule $response */
        $response = $scheduleServiceClient->updateSchedule($request);
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
    $scheduleDisplayName = '[DISPLAY_NAME]';
    $scheduleMaxConcurrentRunCount = 0;

    update_schedule_sample($scheduleDisplayName, $scheduleMaxConcurrentRunCount);
}
// [END aiplatform_v1_generated_ScheduleService_UpdateSchedule_sync]
