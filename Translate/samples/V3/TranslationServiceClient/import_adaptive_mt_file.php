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

// [START translate_v3_generated_TranslationService_ImportAdaptiveMtFile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Translate\V3\ImportAdaptiveMtFileResponse;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * Imports an AdaptiveMtFile and adds all of its sentences into the
 * AdaptiveMtDataset.
 *
 * @param string $formattedParent The resource name of the file, in form of
 *                                `projects/{project-number-or-id}/locations/{location_id}/adaptiveMtDatasets/{dataset}`
 *                                Please see {@see TranslationServiceClient::adaptiveMtDatasetName()} for help formatting this field.
 */
function import_adaptive_mt_file_sample(string $formattedParent): void
{
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ImportAdaptiveMtFileResponse $response */
        $response = $translationServiceClient->importAdaptiveMtFile($formattedParent);
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
    $formattedParent = TranslationServiceClient::adaptiveMtDatasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATASET]'
    );

    import_adaptive_mt_file_sample($formattedParent);
}
// [END translate_v3_generated_TranslationService_ImportAdaptiveMtFile_sync]
