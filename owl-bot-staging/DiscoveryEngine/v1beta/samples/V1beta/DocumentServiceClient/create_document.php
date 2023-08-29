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

// [START discoveryengine_v1beta_generated_DocumentService_CreateDocument_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\Client\DocumentServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\CreateDocumentRequest;
use Google\Cloud\DiscoveryEngine\V1beta\Document;

/**
 * Creates a [Document][google.cloud.discoveryengine.v1beta.Document].
 *
 * @param string $formattedParent The parent resource name, such as
 *                                `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}`. Please see
 *                                {@see DocumentServiceClient::branchName()} for help formatting this field.
 * @param string $documentId      The ID to use for the
 *                                [Document][google.cloud.discoveryengine.v1beta.Document], which will become
 *                                the final component of the
 *                                [Document.name][google.cloud.discoveryengine.v1beta.Document.name].
 *
 *                                If the caller does not have permission to create the
 *                                [Document][google.cloud.discoveryengine.v1beta.Document], regardless of
 *                                whether or not it exists, a `PERMISSION_DENIED` error is returned.
 *
 *                                This field must be unique among all
 *                                [Document][google.cloud.discoveryengine.v1beta.Document]s with the same
 *                                [parent][google.cloud.discoveryengine.v1beta.CreateDocumentRequest.parent].
 *                                Otherwise, an `ALREADY_EXISTS` error is returned.
 *
 *                                This field must conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
 *                                standard with a length limit of 63 characters. Otherwise, an
 *                                `INVALID_ARGUMENT` error is returned.
 */
function create_document_sample(string $formattedParent, string $documentId): void
{
    // Create a client.
    $documentServiceClient = new DocumentServiceClient();

    // Prepare the request message.
    $document = new Document();
    $request = (new CreateDocumentRequest())
        ->setParent($formattedParent)
        ->setDocument($document)
        ->setDocumentId($documentId);

    // Call the API and handle any network failures.
    try {
        /** @var Document $response */
        $response = $documentServiceClient->createDocument($request);
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
    $formattedParent = DocumentServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[BRANCH]'
    );
    $documentId = '[DOCUMENT_ID]';

    create_document_sample($formattedParent, $documentId);
}
// [END discoveryengine_v1beta_generated_DocumentService_CreateDocument_sync]
