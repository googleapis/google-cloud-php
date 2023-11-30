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

// [START dialogflow_v3_generated_Sessions_StreamingDetectIntent_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Dialogflow\Cx\V3\QueryInput;
use Google\Cloud\Dialogflow\Cx\V3\SessionsClient;
use Google\Cloud\Dialogflow\Cx\V3\StreamingDetectIntentRequest;
use Google\Cloud\Dialogflow\Cx\V3\StreamingDetectIntentResponse;

/**
 * Processes a natural language query in audio format in a streaming fashion
 * and returns structured, actionable data as a result. This method is only
 * available via the gRPC API (not REST).
 *
 * Note: Always use agent versions for production traffic.
 * See [Versions and
 * environments](https://cloud.google.com/dialogflow/cx/docs/concept/version).
 *
 * @param string $queryInputLanguageCode The language of the input. See [Language
 *                                       Support](https://cloud.google.com/dialogflow/cx/docs/reference/language)
 *                                       for a list of the currently supported language codes. Note that queries in
 *                                       the same session do not necessarily need to specify the same language.
 */
function streaming_detect_intent_sample(string $queryInputLanguageCode): void
{
    // Create a client.
    $sessionsClient = new SessionsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $queryInput = (new QueryInput())
        ->setLanguageCode($queryInputLanguageCode);
    $request = (new StreamingDetectIntentRequest())
        ->setQueryInput($queryInput);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $sessionsClient->streamingDetectIntent();
        $stream->writeAll([$request,]);

        /** @var StreamingDetectIntentResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
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
    $queryInputLanguageCode = '[LANGUAGE_CODE]';

    streaming_detect_intent_sample($queryInputLanguageCode);
}
// [END dialogflow_v3_generated_Sessions_StreamingDetectIntent_sync]
