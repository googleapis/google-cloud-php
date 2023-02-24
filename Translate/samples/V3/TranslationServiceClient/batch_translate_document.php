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

// [START translate_v3_generated_TranslationService_BatchTranslateDocument_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Translate\V3\BatchDocumentInputConfig;
use Google\Cloud\Translate\V3\BatchDocumentOutputConfig;
use Google\Cloud\Translate\V3\BatchTranslateDocumentResponse;
use Google\Cloud\Translate\V3\TranslationServiceClient;
use Google\Rpc\Status;

/**
 * Translates a large volume of document in asynchronous batch mode.
 * This function provides real-time output as the inputs are being processed.
 * If caller cancels a request, the partial results (for an input file, it's
 * all or nothing) may still be available on the specified output location.
 *
 * This call returns immediately and you can use
 * google.longrunning.Operation.name to poll the status of the call.
 *
 * @param string $formattedParent            Location to make a regional call.
 *
 *                                           Format: `projects/{project-number-or-id}/locations/{location-id}`.
 *
 *                                           The `global` location is not supported for batch translation.
 *
 *                                           Only AutoML Translation models or glossaries within the same region (have
 *                                           the same location-id) can be used, otherwise an INVALID_ARGUMENT (400)
 *                                           error is returned. Please see
 *                                           {@see TranslationServiceClient::locationName()} for help formatting this field.
 * @param string $sourceLanguageCode         The ISO-639 language code of the input document if known, for
 *                                           example, "en-US" or "sr-Latn". Supported language codes are listed in
 *                                           [Language Support](https://cloud.google.com/translate/docs/languages).
 * @param string $targetLanguageCodesElement The ISO-639 language code to use for translation of the input
 *                                           document. Specify up to 10 language codes here.
 */
function batch_translate_document_sample(
    string $formattedParent,
    string $sourceLanguageCode,
    string $targetLanguageCodesElement
): void {
    // Create a client.
    $translationServiceClient = new TranslationServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $targetLanguageCodes = [$targetLanguageCodesElement,];
    $inputConfigs = [new BatchDocumentInputConfig()];
    $outputConfig = new BatchDocumentOutputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $translationServiceClient->batchTranslateDocument(
            $formattedParent,
            $sourceLanguageCode,
            $targetLanguageCodes,
            $inputConfigs,
            $outputConfig
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchTranslateDocumentResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = TranslationServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $sourceLanguageCode = '[SOURCE_LANGUAGE_CODE]';
    $targetLanguageCodesElement = '[TARGET_LANGUAGE_CODES]';

    batch_translate_document_sample($formattedParent, $sourceLanguageCode, $targetLanguageCodesElement);
}
// [END translate_v3_generated_TranslationService_BatchTranslateDocument_sync]
