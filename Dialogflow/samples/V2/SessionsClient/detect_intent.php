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

// [START dialogflow_v2_generated_Sessions_DetectIntent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\SessionsClient;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;
use Google\Cloud\Dialogflow\V2\DetectIntentResponse;

/**
 * Processes a natural language query and returns structured, actionable data
 * as a result. This method is not idempotent, because it may cause contexts
 * and session entity types to be updated, which in turn might affect
 * results of future queries.
 *
 * If you might use
 * [Agent Assist](https://cloud.google.com/dialogflow/docs/#aa)
 * or other CCAI products now or in the future, consider using
 * [AnalyzeContent][google.cloud.dialogflow.v2.Participants.AnalyzeContent]
 * instead of `DetectIntent`. `AnalyzeContent` has additional
 * functionality for Agent Assist and other CCAI products.
 *
 * Note: Always use agent versions for production traffic.
 * See [Versions and
 * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function detect_intent_sample(): void
{
    // Create a client.
    $sessionsClient = new SessionsClient();

    // Prepare the request message.
    $request = new DetectIntentRequest();

    // Call the API and handle any network failures.
    try {
        /** @var DetectIntentResponse $response */
        $response = $sessionsClient->detectIntent($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END dialogflow_v2_generated_Sessions_DetectIntent_sync]
