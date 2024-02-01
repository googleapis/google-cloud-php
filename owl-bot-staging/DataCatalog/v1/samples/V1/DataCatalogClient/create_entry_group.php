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

// [START datacatalog_v1_generated_DataCatalog_CreateEntryGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\Client\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\CreateEntryGroupRequest;
use Google\Cloud\DataCatalog\V1\EntryGroup;

/**
 * Creates an entry group.
 *
 * An entry group contains logically related entries together with [Cloud
 * Identity and Access Management](/data-catalog/docs/concepts/iam) policies.
 * These policies specify users who can create, edit, and view entries
 * within entry groups.
 *
 * Data Catalog automatically creates entry groups with names that start with
 * the `&#64;` symbol for the following resources:
 *
 * * BigQuery entries (`&#64;bigquery`)
 * * Pub/Sub topics (`&#64;pubsub`)
 * * Dataproc Metastore services (`&#64;dataproc_metastore_{SERVICE_NAME_HASH}`)
 *
 * You can create your own entry groups for Cloud Storage fileset entries
 * and custom entries together with the corresponding IAM policies.
 * User-created entry groups can't contain the `&#64;` symbol, it is reserved
 * for automatically created groups.
 *
 * Entry groups, like entries, can be searched.
 *
 * A maximum of 10,000 entry groups may be created per organization across all
 * locations.
 *
 * You must enable the Data Catalog API in the project identified by
 * the `parent` parameter. For more information, see [Data Catalog resource
 * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_entry_group_sample(): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare the request message.
    $request = new CreateEntryGroupRequest();

    // Call the API and handle any network failures.
    try {
        /** @var EntryGroup $response */
        $response = $dataCatalogClient->createEntryGroup($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END datacatalog_v1_generated_DataCatalog_CreateEntryGroup_sync]
