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

// [START translate_v3_generated_TranslationService_GetSupportedLanguages_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\SupportedLanguages;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * Returns a list of supported languages for translation.
 *
 * @param string $formattedParent Project or location to make a call. Must refer to a caller's
 *                                project.
 *
 *                                Format: `projects/{project-number-or-id}` or
 *                                `projects/{project-number-or-id}/locations/{location-id}`.
 *
 *                                For global calls, use `projects/{project-number-or-id}/locations/global` or
 *                                `projects/{project-number-or-id}`.
 *
 *                                Non-global location is required for AutoML models.
 *
 *                                Only models within the same region (have same location-id) can be used,
 *                                otherwise an INVALID_ARGUMENT (400) error is returned. Please see
 *                                {@see TranslationServiceClient::locationName()} for help formatting this field.
 */
function get_supported_languages_sample(string $formattedParent): void
{
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var SupportedLanguages $response */
        $response = $translationServiceClient->getSupportedLanguages($formattedParent);
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

    get_supported_languages_sample($formattedParent);
}
// [END translate_v3_generated_TranslationService_GetSupportedLanguages_sync]
