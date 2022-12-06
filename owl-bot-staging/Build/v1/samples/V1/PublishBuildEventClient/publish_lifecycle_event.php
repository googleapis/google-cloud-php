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

// [START buildeventservice_v1_generated_PublishBuildEvent_PublishLifecycleEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Build\V1\OrderedBuildEvent;
use Google\Cloud\Build\V1\PublishBuildEventClient;

/**
 * Publish a build event stating the new state of a build (typically from the
 * build queue). The BuildEnqueued event must be published before all other
 * events for the same build ID.
 *
 * The backend will persist the event and deliver it to registered frontend
 * jobs immediately without batching.
 *
 * The commit status of the request is reported by the RPC's util_status()
 * function. The error code is the canoncial error code defined in
 * //util/task/codes.proto.
 *
 * @param string $projectId The project this build is associated with.
 *                          This should match the project used for the initial call to
 *                          PublishLifecycleEvent (containing a BuildEnqueued message).
 */
function publish_lifecycle_event_sample(string $projectId): void
{
    // Create a client.
    $publishBuildEventClient = new PublishBuildEventClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $buildEvent = new OrderedBuildEvent();

    // Call the API and handle any network failures.
    try {
        $publishBuildEventClient->publishLifecycleEvent($buildEvent, $projectId);
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
    $projectId = '[PROJECT_ID]';

    publish_lifecycle_event_sample($projectId);
}
// [END buildeventservice_v1_generated_PublishBuildEvent_PublishLifecycleEvent_sync]
