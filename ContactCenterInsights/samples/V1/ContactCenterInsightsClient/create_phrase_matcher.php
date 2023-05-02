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

// [START contactcenterinsights_v1_generated_ContactCenterInsights_CreatePhraseMatcher_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ContactCenterInsights\V1\ContactCenterInsightsClient;
use Google\Cloud\ContactCenterInsights\V1\PhraseMatcher;
use Google\Cloud\ContactCenterInsights\V1\PhraseMatcher\PhraseMatcherType;

/**
 * Creates a phrase matcher.
 *
 * @param string $formattedParent   The parent resource of the phrase matcher. Required. The location
 *                                  to create a phrase matcher for. Format: `projects/<Project
 *                                  ID>/locations/<Location ID>` or `projects/<Project
 *                                  Number>/locations/<Location ID>`
 *                                  Please see {@see ContactCenterInsightsClient::locationName()} for help formatting this field.
 * @param int    $phraseMatcherType The type of this phrase matcher.
 */
function create_phrase_matcher_sample(string $formattedParent, int $phraseMatcherType): void
{
    // Create a client.
    $contactCenterInsightsClient = new ContactCenterInsightsClient();

    // Prepare the request message.
    $phraseMatcher = (new PhraseMatcher())
        ->setType($phraseMatcherType);

    // Call the API and handle any network failures.
    try {
        /** @var PhraseMatcher $response */
        $response = $contactCenterInsightsClient->createPhraseMatcher($formattedParent, $phraseMatcher);
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
    $formattedParent = ContactCenterInsightsClient::locationName('[PROJECT]', '[LOCATION]');
    $phraseMatcherType = PhraseMatcherType::PHRASE_MATCHER_TYPE_UNSPECIFIED;

    create_phrase_matcher_sample($formattedParent, $phraseMatcherType);
}
// [END contactcenterinsights_v1_generated_ContactCenterInsights_CreatePhraseMatcher_sync]
