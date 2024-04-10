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

// [START dialogflow_v3_generated_Sessions_DetectIntent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\SessionsClient;
use Google\Cloud\Dialogflow\Cx\V3\DetectIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\DetectIntentResponse;
use Google\Cloud\Dialogflow\Cx\V3\QueryInput;

/**
 * Processes a natural language query and returns structured, actionable data
 * as a result. This method is not idempotent, because it may cause session
 * entity types to be updated, which in turn might affect results of future
 * queries.
 *
 * Note: Always use agent versions for production traffic.
 * See [Versions and
 * environments](https://cloud.google.com/dialogflow/cx/docs/concept/version).
 *
 * @param string $formattedSession       The name of the session this query is sent to.
 *                                       Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent
 *                                       ID>/sessions/<Session ID>` or `projects/<Project ID>/locations/<Location
 *                                       ID>/agents/<Agent ID>/environments/<Environment ID>/sessions/<Session ID>`.
 *                                       If `Environment ID` is not specified, we assume default 'draft'
 *                                       environment.
 *                                       It's up to the API caller to choose an appropriate `Session ID`. It can be
 *                                       a random number or some type of session identifiers (preferably hashed).
 *                                       The length of the `Session ID` must not exceed 36 characters.
 *
 *                                       For more information, see the [sessions
 *                                       guide](https://cloud.google.com/dialogflow/cx/docs/concept/session).
 *
 *                                       Note: Always use agent versions for production traffic.
 *                                       See [Versions and
 *                                       environments](https://cloud.google.com/dialogflow/cx/docs/concept/version). Please see
 *                                       {@see SessionsClient::sessionName()} for help formatting this field.
 * @param string $queryInputLanguageCode The language of the input. See [Language
 *                                       Support](https://cloud.google.com/dialogflow/cx/docs/reference/language)
 *                                       for a list of the currently supported language codes. Note that queries in
 *                                       the same session do not necessarily need to specify the same language.
 */
function detect_intent_sample(string $formattedSession, string $queryInputLanguageCode): void
{
    // Create a client.
    $sessionsClient = new SessionsClient();

    // Prepare the request message.
    $queryInput = (new QueryInput())
        ->setLanguageCode($queryInputLanguageCode);
    $request = (new DetectIntentRequest())
        ->setSession($formattedSession)
        ->setQueryInput($queryInput);

    // Call the API and handle any network failures.
    try {
        /** @var DetectIntentResponse $response */
        $response = $sessionsClient->detectIntent($request);
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
    $queryInputLanguageCode = '[LANGUAGE_CODE]';

    detect_intent_sample($formattedSession, $queryInputLanguageCode);
}
// [END dialogflow_v3_generated_Sessions_DetectIntent_sync]
