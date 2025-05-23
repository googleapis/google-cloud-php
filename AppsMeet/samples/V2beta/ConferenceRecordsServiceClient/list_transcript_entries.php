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

// [START meet_v2beta_generated_ConferenceRecordsService_ListTranscriptEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Meet\V2beta\Client\ConferenceRecordsServiceClient;
use Google\Apps\Meet\V2beta\ListTranscriptEntriesRequest;
use Google\Apps\Meet\V2beta\TranscriptEntry;

/**
 * Lists the structured transcript entries per transcript. By default, ordered
 * by start time and in ascending order.
 *
 * Note: The transcript entries returned by the Google Meet API might not
 * match the transcription found in the Google Docs transcript file. This can
 * occur when the Google Docs transcript file is modified after generation.
 *
 * @param string $formattedParent Format:
 *                                `conferenceRecords/{conference_record}/transcripts/{transcript}`
 *                                Please see {@see ConferenceRecordsServiceClient::transcriptName()} for help formatting this field.
 */
function list_transcript_entries_sample(string $formattedParent): void
{
    // Create a client.
    $conferenceRecordsServiceClient = new ConferenceRecordsServiceClient();

    // Prepare the request message.
    $request = (new ListTranscriptEntriesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $conferenceRecordsServiceClient->listTranscriptEntries($request);

        /** @var TranscriptEntry $element */
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
    $formattedParent = ConferenceRecordsServiceClient::transcriptName(
        '[CONFERENCE_RECORD]',
        '[TRANSCRIPT]'
    );

    list_transcript_entries_sample($formattedParent);
}
// [END meet_v2beta_generated_ConferenceRecordsService_ListTranscriptEntries_sync]
