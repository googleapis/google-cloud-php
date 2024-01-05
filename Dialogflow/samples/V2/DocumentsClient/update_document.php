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

// [START dialogflow_v2_generated_Documents_UpdateDocument_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\DocumentsClient;
use Google\Cloud\Dialogflow\V2\Document;
use Google\Cloud\Dialogflow\V2\Document\KnowledgeType;
use Google\Cloud\Dialogflow\V2\UpdateDocumentRequest;
use Google\Rpc\Status;

/**
 * Updates the specified document.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
 * - `response`: [Document][google.cloud.dialogflow.v2.Document]
 *
 * @param string $documentDisplayName           The display name of the document. The name must be 1024 bytes or
 *                                              less; otherwise, the creation request fails.
 * @param string $documentMimeType              The MIME type of this document.
 * @param int    $documentKnowledgeTypesElement The knowledge type of document content.
 */
function update_document_sample(
    string $documentDisplayName,
    string $documentMimeType,
    int $documentKnowledgeTypesElement
): void {
    // Create a client.
    $documentsClient = new DocumentsClient();

    // Prepare the request message.
    $documentKnowledgeTypes = [$documentKnowledgeTypesElement,];
    $document = (new Document())
        ->setDisplayName($documentDisplayName)
        ->setMimeType($documentMimeType)
        ->setKnowledgeTypes($documentKnowledgeTypes);
    $request = (new UpdateDocumentRequest())
        ->setDocument($document);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentsClient->updateDocument($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Document $result */
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
    $documentDisplayName = '[DISPLAY_NAME]';
    $documentMimeType = '[MIME_TYPE]';
    $documentKnowledgeTypesElement = KnowledgeType::KNOWLEDGE_TYPE_UNSPECIFIED;

    update_document_sample($documentDisplayName, $documentMimeType, $documentKnowledgeTypesElement);
}
// [END dialogflow_v2_generated_Documents_UpdateDocument_sync]
