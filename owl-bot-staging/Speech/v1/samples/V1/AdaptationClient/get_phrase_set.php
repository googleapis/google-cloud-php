<?php
/*
 * Copyright 2025 Google LLC
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

// [START speech_v1_generated_Adaptation_GetPhraseSet_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Speech\V1\AdaptationClient;
use Google\Cloud\Speech\V1\PhraseSet;

/**
 * Get a phrase set.
 *
 * @param string $formattedName The name of the phrase set to retrieve. Format:
 *
 *                              `projects/{project}/locations/{location}/phraseSets/{phrase_set}`
 *
 *                              Speech-to-Text supports three locations: `global`, `us` (US North America),
 *                              and `eu` (Europe). If you are calling the `speech.googleapis.com`
 *                              endpoint, use the `global` location. To specify a region, use a
 *                              [regional endpoint](https://cloud.google.com/speech-to-text/docs/endpoints)
 *                              with matching `us` or `eu` location value. Please see
 *                              {@see AdaptationClient::phraseSetName()} for help formatting this field.
 */
function get_phrase_set_sample(string $formattedName): void
{
    // Create a client.
    $adaptationClient = new AdaptationClient();

    // Call the API and handle any network failures.
    try {
        /** @var PhraseSet $response */
        $response = $adaptationClient->getPhraseSet($formattedName);
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
    $formattedName = AdaptationClient::phraseSetName('[PROJECT]', '[LOCATION]', '[PHRASE_SET]');

    get_phrase_set_sample($formattedName);
}
// [END speech_v1_generated_Adaptation_GetPhraseSet_sync]
