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

// [START buildeventservice_v1_generated_PublishBuildEvent_PublishBuildToolEventStream_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Build\V1\OrderedBuildEvent;
use Google\Cloud\Build\V1\PublishBuildEventClient;
use Google\Cloud\Build\V1\PublishBuildToolEventStreamRequest;
use Google\Cloud\Build\V1\PublishBuildToolEventStreamResponse;

/**
 * Publish build tool events belonging to the same stream to a backend job
 * using bidirectional streaming.
 *
 * @param string $projectId The project this build is associated with.
 *                          This should match the project used for the initial call to
 *                          PublishLifecycleEvent (containing a BuildEnqueued message).
 */
function publish_build_tool_event_stream_sample(string $projectId): void
{
    // Create a client.
    $publishBuildEventClient = new PublishBuildEventClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $orderedBuildEvent = new OrderedBuildEvent();
    $request = (new PublishBuildToolEventStreamRequest())
        ->setOrderedBuildEvent($orderedBuildEvent)
        ->setProjectId($projectId);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $publishBuildEventClient->publishBuildToolEventStream();
        $stream->writeAll([$request,]);

        /** @var PublishBuildToolEventStreamResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $projectId = '[PROJECT_ID]';

    publish_build_tool_event_stream_sample($projectId);
}
// [END buildeventservice_v1_generated_PublishBuildEvent_PublishBuildToolEventStream_sync]
