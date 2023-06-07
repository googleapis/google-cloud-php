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

// [START discoveryengine_v1_generated_DocumentService_DeleteDocument_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\DocumentServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DeleteDocumentRequest;

/**
 * Deletes a [Document][google.cloud.discoveryengine.v1.Document].
 *
 * @param string $formattedName Full resource name of
 *                              [Document][google.cloud.discoveryengine.v1.Document], such as
 *                              `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document}`.
 *
 *                              If the caller does not have permission to delete the
 *                              [Document][google.cloud.discoveryengine.v1.Document], regardless of whether
 *                              or not it exists, a `PERMISSION_DENIED` error is returned.
 *
 *                              If the [Document][google.cloud.discoveryengine.v1.Document] to delete does
 *                              not exist, a `NOT_FOUND` error is returned. Please see
 *                              {@see DocumentServiceClient::documentName()} for help formatting this field.
 */
function delete_document_sample(string $formattedName): void
{
    // Create a client.
    $documentServiceClient = new DocumentServiceClient();

    // Prepare the request message.
    $request = (new DeleteDocumentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $documentServiceClient->deleteDocument($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = DocumentServiceClient::documentName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[BRANCH]',
        '[DOCUMENT]'
    );

    delete_document_sample($formattedName);
}
// [END discoveryengine_v1_generated_DocumentService_DeleteDocument_sync]
