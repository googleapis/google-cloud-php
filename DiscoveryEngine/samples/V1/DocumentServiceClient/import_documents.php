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

// [START discoveryengine_v1_generated_DocumentService_ImportDocuments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\DocumentServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ImportDocumentsRequest;
use Google\Cloud\DiscoveryEngine\V1\ImportDocumentsResponse;
use Google\Rpc\Status;

/**
 * Bulk import of multiple
 * [Document][google.cloud.discoveryengine.v1.Document]s. Request processing
 * may be synchronous. Non-existing items will be created.
 *
 * Note: It is possible for a subset of the
 * [Document][google.cloud.discoveryengine.v1.Document]s to be successfully
 * updated.
 *
 * @param string $formattedParent The parent branch resource name, such as
 *                                `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}`.
 *                                Requires create/update permission. Please see
 *                                {@see DocumentServiceClient::branchName()} for help formatting this field.
 */
function import_documents_sample(string $formattedParent): void
{
    // Create a client.
    $documentServiceClient = new DocumentServiceClient();

    // Prepare the request message.
    $request = (new ImportDocumentsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $documentServiceClient->importDocuments($request);
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
    $formattedParent = DocumentServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[BRANCH]'
    );

    import_documents_sample($formattedParent);
}
// [END discoveryengine_v1_generated_DocumentService_ImportDocuments_sync]
