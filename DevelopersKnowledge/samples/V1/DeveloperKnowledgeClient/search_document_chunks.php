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

// [START developerknowledge_v1_generated_DeveloperKnowledge_SearchDocumentChunks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Developers\Knowledge\V1\Client\DeveloperKnowledgeClient;
use Google\Developers\Knowledge\V1\DocumentChunk;
use Google\Developers\Knowledge\V1\SearchDocumentChunksRequest;

/**
 * Searches for developer knowledge across Google's developer documentation.
 * Returns [DocumentChunk][google.developers.knowledge.v1.DocumentChunk]s
 * based on the user's query. There may be many chunks from the same
 * [Document][google.developers.knowledge.v1.Document].  To retrieve full
 * documents, use
 * [DeveloperKnowledge.GetDocument][google.developers.knowledge.v1.DeveloperKnowledge.GetDocument]
 * or
 * [DeveloperKnowledge.BatchGetDocuments][google.developers.knowledge.v1.DeveloperKnowledge.BatchGetDocuments]
 * with the
 * [DocumentChunk.parent][google.developers.knowledge.v1.DocumentChunk.parent]
 * returned in the
 * [SearchDocumentChunksResponse.results][google.developers.knowledge.v1.SearchDocumentChunksResponse.results].
 *
 * @param string $query Provides the raw query string provided by the user, such as "How
 *                      to create a Cloud Storage bucket?".
 */
function search_document_chunks_sample(string $query): void
{
    // Create a client.
    $developerKnowledgeClient = new DeveloperKnowledgeClient();

    // Prepare the request message.
    $request = (new SearchDocumentChunksRequest())
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $developerKnowledgeClient->searchDocumentChunks($request);

        /** @var DocumentChunk $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $query = '[QUERY]';

    search_document_chunks_sample($query);
}
// [END developerknowledge_v1_generated_DeveloperKnowledge_SearchDocumentChunks_sync]
