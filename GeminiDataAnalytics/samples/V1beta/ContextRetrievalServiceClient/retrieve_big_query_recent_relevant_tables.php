<?php
/*
 * Copyright 2025 Google LLC
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

// [START geminidataanalytics_v1beta_generated_ContextRetrievalService_RetrieveBigQueryRecentRelevantTables_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GeminiDataAnalytics\V1beta\Client\ContextRetrievalServiceClient;
use Google\Cloud\GeminiDataAnalytics\V1beta\RetrieveBigQueryRecentRelevantTablesRequest;
use Google\Cloud\GeminiDataAnalytics\V1beta\RetrieveBigQueryRecentRelevantTablesResponse;

/**
 * Retrieves BigQuery table references from recently accessed tables.
 *
 * @param string $parent Parent value for RetrieveBigQueryRecentTablesRequest.
 *                       Pattern: `projects/{project}/locations/{location}`
 *                       For location, use "global" for now. Regional location value will be
 *                       supported in the future.
 */
function retrieve_big_query_recent_relevant_tables_sample(string $parent): void
{
    // Create a client.
    $contextRetrievalServiceClient = new ContextRetrievalServiceClient();

    // Prepare the request message.
    $request = (new RetrieveBigQueryRecentRelevantTablesRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var RetrieveBigQueryRecentRelevantTablesResponse $response */
        $response = $contextRetrievalServiceClient->retrieveBigQueryRecentRelevantTables($request);
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
    $parent = '[PARENT]';

    retrieve_big_query_recent_relevant_tables_sample($parent);
}
// [END geminidataanalytics_v1beta_generated_ContextRetrievalService_RetrieveBigQueryRecentRelevantTables_sync]
