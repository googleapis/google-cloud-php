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

// [START dialogflow_v2_generated_Documents_ReloadDocument_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dialogflow\V2\Document;
use Google\Cloud\Dialogflow\V2\DocumentsClient;
use Google\Rpc\Status;

/**
 * Reloads the specified document from its specified source, content_uri or
 * content. The previously loaded content of the document will be deleted.
 * Note: Even when the content of the document has not changed, there still
 * may be side effects because of internal implementation changes.
 *
 * This method is a [long-running
 * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
 * The returned `Operation` type has the following method-specific fields:
 *
 * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
 * - `response`: [Document][google.cloud.dialogflow.v2.Document]
 *
 * Note: The `projects.agent.knowledgeBases.documents` resource is deprecated;
 * only use `projects.knowledgeBases.documents`.
 *
 * @param string $formattedName The name of the document to reload.
 *                              Format: `projects/<Project ID>/locations/<Location
 *                              ID>/knowledgeBases/<Knowledge Base ID>/documents/<Document ID>`
 *                              Please see {@see DocumentsClient::documentName()} for help formatting this field.
 */
function reload_document_sample(string $formattedName): void
{
    // Create a client.
    $documentsClient = new DocumentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentsClient->reloadDocument($formattedName);
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
    $formattedName = DocumentsClient::documentName('[PROJECT]', '[KNOWLEDGE_BASE]', '[DOCUMENT]');

    reload_document_sample($formattedName);
}
// [END dialogflow_v2_generated_Documents_ReloadDocument_sync]
