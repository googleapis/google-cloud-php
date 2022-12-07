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

// [START translate_v3_generated_TranslationService_GetGlossary_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\Glossary;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * Gets a glossary. Returns NOT_FOUND, if the glossary doesn't
 * exist.
 *
 * @param string $formattedName The name of the glossary to retrieve. Please see
 *                              {@see TranslationServiceClient::glossaryName()} for help formatting this field.
 */
function get_glossary_sample(string $formattedName): void
{
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Glossary $response */
        $response = $translationServiceClient->getGlossary($formattedName);
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
    $formattedName = TranslationServiceClient::glossaryName('[PROJECT]', '[LOCATION]', '[GLOSSARY]');

    get_glossary_sample($formattedName);
}
// [END translate_v3_generated_TranslationService_GetGlossary_sync]
