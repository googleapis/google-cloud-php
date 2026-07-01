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

// [START ces_v1_generated_SessionService_BidiRunSession_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Ces\V1\BidiSessionClientMessage;
use Google\Cloud\Ces\V1\BidiSessionServerMessage;
use Google\Cloud\Ces\V1\Client\SessionServiceClient;

/**
 * Establishes a bidirectional streaming connection with the CES agent.
 * The agent processes continuous multimodal inputs (e.g., text, audio) and
 * generates real-time multimodal output streams.
 *
 * --- Client Request Stream ---
 * The client streams requests in the following order:
 *
 * 1.  Initialization:
 * The first message must contain
 * [SessionConfig][google.cloud.ces.v1.BidiSessionClientMessage.config].
 * For audio sessions, this should also include
 * [InputAudioConfig][google.cloud.ces.v1.SessionConfig.input_audio_config]
 * and
 * [OutputAudioConfig][google.cloud.ces.v1.SessionConfig.output_audio_config]
 * to define audio processing and synthesis parameters.
 *
 * 2.  Interaction:
 * Subsequent messages stream
 * [SessionInput][google.cloud.ces.v1.BidiSessionClientMessage.realtime_input]
 * containing real-time user input data.
 *
 * 3.  Termination:
 * The client should half-close the stream when there is no more user
 * input. It should also half-close upon receiving
 * [EndSession][google.cloud.ces.v1.BidiSessionServerMessage.end_session]
 * or [GoAway][google.cloud.ces.v1.BidiSessionServerMessage.go_away] from
 * the agent.
 *
 * --- Server Response Stream ---
 * For each interaction turn, the agent streams messages in the following
 * sequence:
 *
 * 1.  Speech Recognition (First N messages):
 * Contains
 * [RecognitionResult][google.cloud.ces.v1.BidiSessionServerMessage.recognition_result]
 * representing the concatenated user speech segments captured so far.
 * This is only populated for audio sessions.
 *
 * 2.  Response (Next M messages):
 * Contains
 * [SessionOutput][google.cloud.ces.v1.BidiSessionServerMessage.session_output]
 * delivering the agent's response in various modalities (e.g., text,
 * audio).
 *
 * 3.  Turn Completion (Final message of the turn):
 * Contains
 * [SessionOutput][google.cloud.ces.v1.BidiSessionServerMessage.session_output]
 * with [turn_completed][google.cloud.ces.v1.SessionOutput.turn_completed]
 * set to true. This signals the end of the current turn and includes
 * [DiagnosticInfo][google.cloud.ces.v1.SessionOutput.diagnostic_info]
 * with execution details.
 *
 * --- Audio Best Practices ---
 * 1.  Streaming:
 * Stream [audio data][google.cloud.ces.v1.SessionInput.audio]
 * **CONTINUOUSLY**, even during silence. Recommended chunk size: 40-120ms
 * (balances latency vs. efficiency).
 *
 * 2.  Playback & Interruption:
 * Play [audio responses][google.cloud.ces.v1.SessionOutput.audio] upon
 * receipt. Stop playback immediately if an
 * [InterruptionSignal][google.cloud.ces.v1.BidiSessionServerMessage.interruption_signal]
 * is received (e.g., user barge-in or new agent response).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function bidi_run_session_sample(): void
{
    // Create a client.
    $sessionServiceClient = new SessionServiceClient();

    // Prepare the request message.
    $request = new BidiSessionClientMessage();

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $sessionServiceClient->bidiRunSession();
        $stream->writeAll([$request,]);

        /** @var BidiSessionServerMessage $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END ces_v1_generated_SessionService_BidiRunSession_sync]
