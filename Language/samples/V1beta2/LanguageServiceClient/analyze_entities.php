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

// [START language_v1beta2_generated_LanguageService_AnalyzeEntities_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse;
use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\LanguageServiceClient;

/**
 * Finds named entities (currently proper names and common nouns) in the text
 * along with entity types, salience, mentions for each entity, and
 * other properties.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function analyze_entities_sample(): void
{
    // Create a client.
    $languageServiceClient = new LanguageServiceClient();

    // Prepare the request message.
    $document = new Document();

    // Call the API and handle any network failures.
    try {
        /** @var AnalyzeEntitiesResponse $response */
        $response = $languageServiceClient->analyzeEntities($document);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END language_v1beta2_generated_LanguageService_AnalyzeEntities_sync]
