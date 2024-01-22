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

// [START cloudscheduler_v1_generated_CloudScheduler_UpdateJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Scheduler\V1\Client\CloudSchedulerClient;
use Google\Cloud\Scheduler\V1\Job;
use Google\Cloud\Scheduler\V1\UpdateJobRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a job.
 *
 * If successful, the updated [Job][google.cloud.scheduler.v1.Job] is
 * returned. If the job does not exist, `NOT_FOUND` is returned.
 *
 * If UpdateJob does not successfully return, it is possible for the
 * job to be in an
 * [Job.State.UPDATE_FAILED][google.cloud.scheduler.v1.Job.State.UPDATE_FAILED]
 * state. A job in this state may not be executed. If this happens, retry the
 * UpdateJob request until a successful response is received.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_job_sample(): void
{
    // Create a client.
    $cloudSchedulerClient = new CloudSchedulerClient();

    // Prepare the request message.
    $job = new Job();
    $updateMask = new FieldMask();
    $request = (new UpdateJobRequest())
        ->setJob($job)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Job $response */
        $response = $cloudSchedulerClient->updateJob($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudscheduler_v1_generated_CloudScheduler_UpdateJob_sync]
