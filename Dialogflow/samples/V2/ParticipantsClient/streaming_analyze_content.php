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

// [START dialogflow_v2_generated_Participants_StreamingAnalyzeContent_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Dialogflow\V2\Client\ParticipantsClient;
use Google\Cloud\Dialogflow\V2\StreamingAnalyzeContentRequest;
use Google\Cloud\Dialogflow\V2\StreamingAnalyzeContentResponse;

/**
 * Adds a text (chat, for example), or audio (phone recording, for example)
 * message from a participant into the conversation.
 * Note: This method is only available through the gRPC API (not REST).
 *
 * The top-level message sent to the client by the server is
 * `StreamingAnalyzeContentResponse`. Multiple response messages can be
 * returned in order. The first one or more messages contain the
 * `recognition_result` field. Each result represents a more complete
 * transcript of what the user said. The next message contains the
 * `reply_text` field and potentially the `reply_audio` field. The message can
 * also contain the `automated_agent_reply` field.
 *
 * Note: Always use agent versions for production traffic
 * sent to virtual agents. See [Versions and
 * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
 *
 * @param string $formattedParticipant The name of the participant this text comes from.
 *                                     Format: `projects/<Project ID>/locations/<Location
 *                                     ID>/conversations/<Conversation ID>/participants/<Participant ID>`. Please see
 *                                     {@see ParticipantsClient::participantName()} for help formatting this field.
 */
function streaming_analyze_content_sample(string $formattedParticipant): void
{
    // Create a client.
    $participantsClient = new ParticipantsClient();

    // Prepare the request message.
    $request = (new StreamingAnalyzeContentRequest())
        ->setParticipant($formattedParticipant);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $participantsClient->streamingAnalyzeContent();
        $stream->writeAll([$request,]);

        /** @var StreamingAnalyzeContentResponse $element */
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
    $formattedParticipant = ParticipantsClient::participantName(
        '[PROJECT]',
        '[CONVERSATION]',
        '[PARTICIPANT]'
    );

    streaming_analyze_content_sample($formattedParticipant);
}
// [END dialogflow_v2_generated_Participants_StreamingAnalyzeContent_sync]
