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

// [START aiplatform_v1_generated_ScheduleService_ResumeSchedule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\ScheduleServiceClient;
use Google\Cloud\AIPlatform\V1\ResumeScheduleRequest;

/**
 * Resumes a paused Schedule to start scheduling new runs. Will mark
 * [Schedule.state][google.cloud.aiplatform.v1.Schedule.state] to 'ACTIVE'.
 * Only paused Schedule can be resumed.
 *
 * When the Schedule is resumed, new runs will be scheduled starting from the
 * next execution time after the current time based on the time_specification
 * in the Schedule. If [Schedule.catchUp][] is set up true, all
 * missed runs will be scheduled for backfill first.
 *
 * @param string $formattedName The name of the Schedule resource to be resumed.
 *                              Format:
 *                              `projects/{project}/locations/{location}/schedules/{schedule}`
 *                              Please see {@see ScheduleServiceClient::scheduleName()} for help formatting this field.
 */
function resume_schedule_sample(string $formattedName): void
{
    // Create a client.
    $scheduleServiceClient = new ScheduleServiceClient();

    // Prepare the request message.
    $request = (new ResumeScheduleRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $scheduleServiceClient->resumeSchedule($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = ScheduleServiceClient::scheduleName('[PROJECT]', '[LOCATION]', '[SCHEDULE]');

    resume_schedule_sample($formattedName);
}
// [END aiplatform_v1_generated_ScheduleService_ResumeSchedule_sync]
