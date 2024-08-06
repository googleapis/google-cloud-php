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

// [START translate_v3_generated_TranslationService_RomanizeText_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\RomanizeTextRequest;
use Google\Cloud\Translate\V3\RomanizeTextResponse;

/**
 * Romanize input text written in non-Latin scripts to Latin text.
 *
 * @param string $formattedParent Project or location to make a call. Must refer to a caller's
 *                                project.
 *
 *                                Format: `projects/{project-number-or-id}/locations/{location-id}` or
 *                                `projects/{project-number-or-id}`.
 *
 *                                For global calls, use `projects/{project-number-or-id}/locations/global` or
 *                                `projects/{project-number-or-id}`. Please see
 *                                {@see TranslationServiceClient::locationName()} for help formatting this field.
 * @param string $contentsElement The content of the input in string format.
 */
function romanize_text_sample(string $formattedParent, string $contentsElement): void
{
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Prepare the request message.
    $contents = [$contentsElement,];
    $request = (new RomanizeTextRequest())
        ->setParent($formattedParent)
        ->setContents($contents);

    // Call the API and handle any network failures.
    try {
        /** @var RomanizeTextResponse $response */
        $response = $translationServiceClient->romanizeText($request);
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
    $formattedParent = TranslationServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $contentsElement = '[CONTENTS]';

    romanize_text_sample($formattedParent, $contentsElement);
}
// [END translate_v3_generated_TranslationService_RomanizeText_sync]
