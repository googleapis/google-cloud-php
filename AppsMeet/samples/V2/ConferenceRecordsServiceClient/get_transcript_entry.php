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

// [START meet_v2_generated_ConferenceRecordsService_GetTranscriptEntry_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Meet\V2\Client\ConferenceRecordsServiceClient;
use Google\Apps\Meet\V2\GetTranscriptEntryRequest;
use Google\Apps\Meet\V2\TranscriptEntry;

/**
 * Gets a `TranscriptEntry` resource by entry ID.
 *
 * Note: The transcript entries returned by the Google Meet API might not
 * match the transcription found in the Google Docs transcript file. This can
 * occur when the Google Docs transcript file is modified after generation.
 *
 * @param string $formattedName Resource name of the `TranscriptEntry`. Please see
 *                              {@see ConferenceRecordsServiceClient::transcriptEntryName()} for help formatting this field.
 */
function get_transcript_entry_sample(string $formattedName): void
{
    // Create a client.
    $conferenceRecordsServiceClient = new ConferenceRecordsServiceClient();

    // Prepare the request message.
    $request = (new GetTranscriptEntryRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var TranscriptEntry $response */
        $response = $conferenceRecordsServiceClient->getTranscriptEntry($request);
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
    $formattedName = ConferenceRecordsServiceClient::transcriptEntryName(
        '[CONFERENCE_RECORD]',
        '[TRANSCRIPT]',
        '[ENTRY]'
    );

    get_transcript_entry_sample($formattedName);
}
// [END meet_v2_generated_ConferenceRecordsService_GetTranscriptEntry_sync]
