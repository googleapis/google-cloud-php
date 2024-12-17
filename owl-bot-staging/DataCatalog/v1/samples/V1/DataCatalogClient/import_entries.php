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

// [START datacatalog_v1_generated_DataCatalog_ImportEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DataCatalog\V1\Client\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\ImportEntriesRequest;
use Google\Cloud\DataCatalog\V1\ImportEntriesResponse;
use Google\Rpc\Status;

/**
 * Imports entries from a source, such as data previously dumped into a
 * Cloud Storage bucket, into Data Catalog. Import of entries
 * is a sync operation that reconciles the state of the third-party system
 * with the Data Catalog.
 *
 * `ImportEntries` accepts source data snapshots of a third-party system.
 * Snapshot should be delivered as a .wire or base65-encoded .txt file
 * containing a sequence of Protocol Buffer messages of
 * [DumpItem][google.cloud.datacatalog.v1.DumpItem] type.
 *
 * `ImportEntries` returns a [long-running operation]
 * [google.longrunning.Operation] resource that can be queried with
 * [Operations.GetOperation][google.longrunning.Operations.GetOperation]
 * to return
 * [ImportEntriesMetadata][google.cloud.datacatalog.v1.ImportEntriesMetadata]
 * and an
 * [ImportEntriesResponse][google.cloud.datacatalog.v1.ImportEntriesResponse]
 * message.
 *
 * @param string $formattedParent Target entry group for ingested entries. Please see
 *                                {@see DataCatalogClient::entryGroupName()} for help formatting this field.
 */
function import_entries_sample(string $formattedParent): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare the request message.
    $request = (new ImportEntriesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataCatalogClient->importEntries($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportEntriesResponse $result */
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
    $formattedParent = DataCatalogClient::entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');

    import_entries_sample($formattedParent);
}
// [END datacatalog_v1_generated_DataCatalog_ImportEntries_sync]
