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

// [START containeranalysis_v1_generated_Grafeas_ListNoteOccurrences_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Grafeas\V1\GrafeasClient;
use Grafeas\V1\Occurrence;

/**
 * Lists occurrences referencing the specified note. Provider projects can use
 * this method to get all occurrences across consumer projects referencing the
 * specified note.
 *
 * @param string $formattedName The name of the note to list occurrences for in the form of
 *                              `projects/[PROVIDER_ID]/notes/[NOTE_ID]`. Please see
 *                              {@see GrafeasClient::noteName()} for help formatting this field.
 */
function list_note_occurrences_sample(string $formattedName): void
{
    // Create a client.
    $grafeasClient = new GrafeasClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $grafeasClient->listNoteOccurrences($formattedName);

        /** @var Occurrence $element */
        foreach ($response as $element) {
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
    $formattedName = GrafeasClient::noteName('[PROJECT]', '[NOTE]');

    list_note_occurrences_sample($formattedName);
}
// [END containeranalysis_v1_generated_Grafeas_ListNoteOccurrences_sync]
