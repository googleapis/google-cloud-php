<?php
/*
 * Copyright 2026 Google LLC
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

// [START aiplatform_v1_generated_SessionService_AppendEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\AppendEventRequest;
use Google\Cloud\AIPlatform\V1\AppendEventResponse;
use Google\Cloud\AIPlatform\V1\Client\SessionServiceClient;
use Google\Cloud\AIPlatform\V1\SessionEvent;
use Google\Protobuf\Timestamp;

/**
 * Appends an event to a given session.
 *
 * @param string $formattedName     The resource name of the session to append event to.
 *                                  Format:
 *                                  `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}/sessions/{session}`
 *                                  Please see {@see SessionServiceClient::sessionName()} for help formatting this field.
 * @param string $eventAuthor       The name of the agent that sent the event, or user.
 * @param string $eventInvocationId The invocation id of the event, multiple events can have the same
 *                                  invocation id.
 */
function append_event_sample(
    string $formattedName,
    string $eventAuthor,
    string $eventInvocationId
): void {
    // Create a client.
    $sessionServiceClient = new SessionServiceClient();

    // Prepare the request message.
    $eventTimestamp = new Timestamp();
    $event = (new SessionEvent())
        ->setAuthor($eventAuthor)
        ->setInvocationId($eventInvocationId)
        ->setTimestamp($eventTimestamp);
    $request = (new AppendEventRequest())
        ->setName($formattedName)
        ->setEvent($event);

    // Call the API and handle any network failures.
    try {
        /** @var AppendEventResponse $response */
        $response = $sessionServiceClient->appendEvent($request);
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
    $formattedName = SessionServiceClient::sessionName(
        '[PROJECT]',
        '[LOCATION]',
        '[REASONING_ENGINE]',
        '[SESSION]'
    );
    $eventAuthor = '[AUTHOR]';
    $eventInvocationId = '[INVOCATION_ID]';

    append_event_sample($formattedName, $eventAuthor, $eventInvocationId);
}
// [END aiplatform_v1_generated_SessionService_AppendEvent_sync]
