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

// [START aiplatform_v1_generated_VertexRagDataService_ImportRagFiles_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\VertexRagDataServiceClient;
use Google\Cloud\AIPlatform\V1\ImportRagFilesConfig;
use Google\Cloud\AIPlatform\V1\ImportRagFilesRequest;
use Google\Cloud\AIPlatform\V1\ImportRagFilesResponse;
use Google\Rpc\Status;

/**
 * Import files from Google Cloud Storage or Google Drive into a RagCorpus.
 *
 * @param string $formattedParent The name of the RagCorpus resource into which to import files.
 *                                Format:
 *                                `projects/{project}/locations/{location}/ragCorpora/{rag_corpus}`
 *                                Please see {@see VertexRagDataServiceClient::ragCorpusName()} for help formatting this field.
 */
function import_rag_files_sample(string $formattedParent): void
{
    // Create a client.
    $vertexRagDataServiceClient = new VertexRagDataServiceClient();

    // Prepare the request message.
    $importRagFilesConfig = new ImportRagFilesConfig();
    $request = (new ImportRagFilesRequest())
        ->setParent($formattedParent)
        ->setImportRagFilesConfig($importRagFilesConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vertexRagDataServiceClient->importRagFiles($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportRagFilesResponse $result */
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
    $formattedParent = VertexRagDataServiceClient::ragCorpusName(
        '[PROJECT]',
        '[LOCATION]',
        '[RAG_CORPUS]'
    );

    import_rag_files_sample($formattedParent);
}
// [END aiplatform_v1_generated_VertexRagDataService_ImportRagFiles_sync]
