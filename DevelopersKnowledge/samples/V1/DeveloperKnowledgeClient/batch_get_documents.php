<?php
/*
 * Copyright 2026 Google LLC
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

// [START developerknowledge_v1_generated_DeveloperKnowledge_BatchGetDocuments_sync]
use Google\ApiCore\ApiException;
use Google\Developers\Knowledge\V1\BatchGetDocumentsRequest;
use Google\Developers\Knowledge\V1\BatchGetDocumentsResponse;
use Google\Developers\Knowledge\V1\Client\DeveloperKnowledgeClient;

/**
 * Retrieves multiple documents, each with its full Markdown content.
 *
 * @param string $formattedNamesElement Specifies the names of the documents to retrieve. A maximum of 20
 *                                      documents can be retrieved in a batch. The documents are returned in the
 *                                      same order as the `names` in the request.
 *
 *                                      Format: `documents/{uri_without_scheme}`
 *                                      Example: `documents/docs.cloud.google.com/storage/docs/creating-buckets`
 *                                      Please see {@see DeveloperKnowledgeClient::documentName()} for help formatting this field.
 */
function batch_get_documents_sample(string $formattedNamesElement): void
{
    // Create a client.
    $developerKnowledgeClient = new DeveloperKnowledgeClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchGetDocumentsRequest())
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchGetDocumentsResponse $response */
        $response = $developerKnowledgeClient->batchGetDocuments($request);
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
    $formattedNamesElement = DeveloperKnowledgeClient::documentName('[DOCUMENT]');

    batch_get_documents_sample($formattedNamesElement);
}
// [END developerknowledge_v1_generated_DeveloperKnowledge_BatchGetDocuments_sync]
