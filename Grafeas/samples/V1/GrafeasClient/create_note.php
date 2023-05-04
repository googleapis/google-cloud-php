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

// [START containeranalysis_v1_generated_Grafeas_CreateNote_sync]
use Google\ApiCore\ApiException;
use Grafeas\V1\GrafeasClient;
use Grafeas\V1\Note;

/**
 * Creates a new note.
 *
 * @param string $formattedParent The name of the project in the form of `projects/[PROJECT_ID]`, under which
 *                                the note is to be created. Please see
 *                                {@see GrafeasClient::projectName()} for help formatting this field.
 * @param string $noteId          The ID to use for this note.
 */
function create_note_sample(string $formattedParent, string $noteId): void
{
    // Create a client.
    $grafeasClient = new GrafeasClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $note = new Note();

    // Call the API and handle any network failures.
    try {
        /** @var Note $response */
        $response = $grafeasClient->createNote($formattedParent, $noteId, $note);
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
    $formattedParent = GrafeasClient::projectName('[PROJECT]');
    $noteId = '[NOTE_ID]';

    create_note_sample($formattedParent, $noteId);
}
// [END containeranalysis_v1_generated_Grafeas_CreateNote_sync]
