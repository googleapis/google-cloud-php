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

// [START aiplatform_v1_generated_VertexRagDataService_UploadRagFile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\VertexRagDataServiceClient;
use Google\Cloud\AIPlatform\V1\RagFile;
use Google\Cloud\AIPlatform\V1\UploadRagFileConfig;
use Google\Cloud\AIPlatform\V1\UploadRagFileRequest;
use Google\Cloud\AIPlatform\V1\UploadRagFileResponse;

/**
 * Upload a file into a RagCorpus.
 *
 * @param string $formattedParent    The name of the RagCorpus resource into which to upload the file.
 *                                   Format:
 *                                   `projects/{project}/locations/{location}/ragCorpora/{rag_corpus}`
 *                                   Please see {@see VertexRagDataServiceClient::ragCorpusName()} for help formatting this field.
 * @param string $ragFileDisplayName The display name of the RagFile.
 *                                   The name can be up to 128 characters long and can consist of any UTF-8
 *                                   characters.
 */
function upload_rag_file_sample(string $formattedParent, string $ragFileDisplayName): void
{
    // Create a client.
    $vertexRagDataServiceClient = new VertexRagDataServiceClient();

    // Prepare the request message.
    $ragFile = (new RagFile())
        ->setDisplayName($ragFileDisplayName);
    $uploadRagFileConfig = new UploadRagFileConfig();
    $request = (new UploadRagFileRequest())
        ->setParent($formattedParent)
        ->setRagFile($ragFile)
        ->setUploadRagFileConfig($uploadRagFileConfig);

    // Call the API and handle any network failures.
    try {
        /** @var UploadRagFileResponse $response */
        $response = $vertexRagDataServiceClient->uploadRagFile($request);
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
    $formattedParent = VertexRagDataServiceClient::ragCorpusName(
        '[PROJECT]',
        '[LOCATION]',
        '[RAG_CORPUS]'
    );
    $ragFileDisplayName = '[DISPLAY_NAME]';

    upload_rag_file_sample($formattedParent, $ragFileDisplayName);
}
// [END aiplatform_v1_generated_VertexRagDataService_UploadRagFile_sync]
