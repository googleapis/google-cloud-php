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

// [START dialogflow_v2_generated_Documents_ImportDocuments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Client\DocumentsClient;
use Google\Cloud\Dialogflow\V2\Document\KnowledgeType;
use Google\Cloud\Dialogflow\V2\ImportDocumentTemplate;
use Google\Cloud\Dialogflow\V2\ImportDocumentsRequest;
use Google\Cloud\Dialogflow\V2\ImportDocumentsResponse;
use Google\Rpc\Status;

/**
 * Creates documents by importing data from external sources.
 * Dialogflow supports up to 350 documents in each request. If you try to
 * import more, Dialogflow will return an error.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`:
 * [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
 * - `response`:
 * [ImportDocumentsResponse][google.cloud.dialogflow.v2.ImportDocumentsResponse]
 *
 * @param string $formattedParent                       The knowledge base to import documents into.
 *                                                      Format: `projects/<Project ID>/locations/<Location
 *                                                      ID>/knowledgeBases/<Knowledge Base ID>`. Please see
 *                                                      {@see DocumentsClient::knowledgeBaseName()} for help formatting this field.
 * @param string $documentTemplateMimeType              The MIME type of the document.
 * @param int    $documentTemplateKnowledgeTypesElement The knowledge type of document content.
 */
function import_documents_sample(
    string $formattedParent,
    string $documentTemplateMimeType,
    int $documentTemplateKnowledgeTypesElement
): void {
    // Create a client.
    $documentsClient = new DocumentsClient();

    // Prepare the request message.
    $documentTemplateKnowledgeTypes = [$documentTemplateKnowledgeTypesElement,];
    $documentTemplate = (new ImportDocumentTemplate())
        ->setMimeType($documentTemplateMimeType)
        ->setKnowledgeTypes($documentTemplateKnowledgeTypes);
    $request = (new ImportDocumentsRequest())
        ->setParent($formattedParent)
        ->setDocumentTemplate($documentTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentsClient->importDocuments($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportDocumentsResponse $result */
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
    $formattedParent = DocumentsClient::knowledgeBaseName('[PROJECT]', '[KNOWLEDGE_BASE]');
    $documentTemplateMimeType = '[MIME_TYPE]';
    $documentTemplateKnowledgeTypesElement = KnowledgeType::KNOWLEDGE_TYPE_UNSPECIFIED;

    import_documents_sample(
        $formattedParent,
        $documentTemplateMimeType,
        $documentTemplateKnowledgeTypesElement
    );
}
// [END dialogflow_v2_generated_Documents_ImportDocuments_sync]
