<?php
/*
 * Copyright 2024 Google LLC
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

// [START speech_v1_generated_Adaptation_CreatePhraseSet_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Speech\V1\AdaptationClient;
use Google\Cloud\Speech\V1\PhraseSet;

/**
 * Create a set of phrase hints. Each item in the set can be a single word or
 * a multi-word phrase. The items in the PhraseSet are favored by the
 * recognition model when you send a call that includes the PhraseSet.
 *
 * @param string $formattedParent The parent resource where this phrase set will be created.
 *                                Format:
 *
 *                                `projects/{project}/locations/{location}`
 *
 *                                Speech-to-Text supports three locations: `global`, `us` (US North America),
 *                                and `eu` (Europe). If you are calling the `speech.googleapis.com`
 *                                endpoint, use the `global` location. To specify a region, use a
 *                                [regional endpoint](https://cloud.google.com/speech-to-text/docs/endpoints)
 *                                with matching `us` or `eu` location value. Please see
 *                                {@see AdaptationClient::locationName()} for help formatting this field.
 * @param string $phraseSetId     The ID to use for the phrase set, which will become the final
 *                                component of the phrase set's resource name.
 *
 *                                This value should restrict to letters, numbers, and hyphens, with the first
 *                                character a letter, the last a letter or a number, and be 4-63 characters.
 */
function create_phrase_set_sample(string $formattedParent, string $phraseSetId): void
{
    // Create a client.
    $adaptationClient = new AdaptationClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $phraseSet = new PhraseSet();

    // Call the API and handle any network failures.
    try {
        /** @var PhraseSet $response */
        $response = $adaptationClient->createPhraseSet($formattedParent, $phraseSetId, $phraseSet);
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
    $formattedParent = AdaptationClient::locationName('[PROJECT]', '[LOCATION]');
    $phraseSetId = '[PHRASE_SET_ID]';

    create_phrase_set_sample($formattedParent, $phraseSetId);
}
// [END speech_v1_generated_Adaptation_CreatePhraseSet_sync]
