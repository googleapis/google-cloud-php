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

// [START dialogflow_v3_generated_Sessions_SubmitAnswerFeedback_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\AnswerFeedback;
use Google\Cloud\Dialogflow\Cx\V3\SessionsClient;

/**
 * Updates the feedback received from the user for a single turn of the bot
 * response.
 *
 * @param string $formattedSession The name of the session the feedback was sent to. Please see
 *                                 {@see SessionsClient::sessionName()} for help formatting this field.
 * @param string $responseId       ID of the response to update its feedback. This is the same as
 *                                 DetectIntentResponse.response_id.
 */
function submit_answer_feedback_sample(string $formattedSession, string $responseId): void
{
    // Create a client.
    $sessionsClient = new SessionsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $answerFeedback = new AnswerFeedback();

    // Call the API and handle any network failures.
    try {
        /** @var AnswerFeedback $response */
        $response = $sessionsClient->submitAnswerFeedback($formattedSession, $responseId, $answerFeedback);
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
    $formattedSession = SessionsClient::sessionName('[PROJECT]', '[LOCATION]', '[AGENT]', '[SESSION]');
    $responseId = '[RESPONSE_ID]';

    submit_answer_feedback_sample($formattedSession, $responseId);
}
// [END dialogflow_v3_generated_Sessions_SubmitAnswerFeedback_sync]
