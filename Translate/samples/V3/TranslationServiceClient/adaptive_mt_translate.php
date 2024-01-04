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

// [START translate_v3_generated_TranslationService_AdaptiveMtTranslate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\AdaptiveMtTranslateResponse;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * Translate text using Adaptive MT.
 *
 * @param string $formattedParent  Location to make a regional call.
 *
 *                                 Format: `projects/{project-number-or-id}/locations/{location-id}`. Please see
 *                                 {@see TranslationServiceClient::locationName()} for help formatting this field.
 * @param string $formattedDataset The resource name for the dataset to use for adaptive MT.
 *                                 `projects/{project}/locations/{location-id}/adaptiveMtDatasets/{dataset}`
 *                                 Please see {@see TranslationServiceClient::adaptiveMtDatasetName()} for help formatting this field.
 * @param string $contentElement   The content of the input in string format.
 *                                 For now only one sentence per request is supported.
 */
function adaptive_mt_translate_sample(
    string $formattedParent,
    string $formattedDataset,
    string $contentElement
): void {
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $content = [$contentElement,];

    // Call the API and handle any network failures.
    try {
        /** @var AdaptiveMtTranslateResponse $response */
        $response = $translationServiceClient->adaptiveMtTranslate(
            $formattedParent,
            $formattedDataset,
            $content
        );
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
    $formattedDataset = TranslationServiceClient::adaptiveMtDatasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATASET]'
    );
    $contentElement = '[CONTENT]';

    adaptive_mt_translate_sample($formattedParent, $formattedDataset, $contentElement);
}
// [END translate_v3_generated_TranslationService_AdaptiveMtTranslate_sync]
