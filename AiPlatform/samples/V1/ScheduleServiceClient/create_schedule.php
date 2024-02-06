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

// [START aiplatform_v1_generated_ScheduleService_CreateSchedule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\ScheduleServiceClient;
use Google\Cloud\AIPlatform\V1\CreateScheduleRequest;
use Google\Cloud\AIPlatform\V1\Schedule;

/**
 * Creates a Schedule.
 *
 * @param string $formattedParent               The resource name of the Location to create the Schedule in.
 *                                              Format: `projects/{project}/locations/{location}`
 *                                              Please see {@see ScheduleServiceClient::locationName()} for help formatting this field.
 * @param string $scheduleDisplayName           User provided name of the Schedule.
 *                                              The name can be up to 128 characters long and can consist of any UTF-8
 *                                              characters.
 * @param int    $scheduleMaxConcurrentRunCount Maximum number of runs that can be started concurrently for this
 *                                              Schedule. This is the limit for starting the scheduled requests and not the
 *                                              execution of the operations/jobs created by the requests (if applicable).
 */
function create_schedule_sample(
    string $formattedParent,
    string $scheduleDisplayName,
    int $scheduleMaxConcurrentRunCount
): void {
    // Create a client.
    $scheduleServiceClient = new ScheduleServiceClient();

    // Prepare the request message.
    $schedule = (new Schedule())
        ->setDisplayName($scheduleDisplayName)
        ->setMaxConcurrentRunCount($scheduleMaxConcurrentRunCount);
    $request = (new CreateScheduleRequest())
        ->setParent($formattedParent)
        ->setSchedule($schedule);

    // Call the API and handle any network failures.
    try {
        /** @var Schedule $response */
        $response = $scheduleServiceClient->createSchedule($request);
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
    $formattedParent = ScheduleServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $scheduleDisplayName = '[DISPLAY_NAME]';
    $scheduleMaxConcurrentRunCount = 0;

    create_schedule_sample($formattedParent, $scheduleDisplayName, $scheduleMaxConcurrentRunCount);
}
// [END aiplatform_v1_generated_ScheduleService_CreateSchedule_sync]
