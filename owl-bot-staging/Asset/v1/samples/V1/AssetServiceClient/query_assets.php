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

// [START cloudasset_v1_generated_AssetService_QueryAssets_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\Client\AssetServiceClient;
use Google\Cloud\Asset\V1\QueryAssetsRequest;
use Google\Cloud\Asset\V1\QueryAssetsResponse;

/**
 * Issue a job that queries assets using a SQL statement compatible with
 * [BigQuery SQL](https://cloud.google.com/bigquery/docs/introduction-sql).
 *
 * If the query execution finishes within timeout and there's no pagination,
 * the full query results will be returned in the `QueryAssetsResponse`.
 *
 * Otherwise, full query results can be obtained by issuing extra requests
 * with the `job_reference` from the a previous `QueryAssets` call.
 *
 * Note, the query result has approximately 10 GB limitation enforced by
 * [BigQuery](https://cloud.google.com/bigquery/docs/best-practices-performance-output).
 * Queries return larger results will result in errors.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function query_assets_sample(): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare the request message.
    $request = new QueryAssetsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var QueryAssetsResponse $response */
        $response = $assetServiceClient->queryAssets($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudasset_v1_generated_AssetService_QueryAssets_sync]
