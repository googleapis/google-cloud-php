<?php
/*
 * Copyright 2026 Google LLC
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

// [START spanner_v1_generated_Spanner_FetchCacheUpdate_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Spanner\V1\CacheUpdate;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\FetchCacheUpdateRequest;

/**
 * Retrieves a cache update for a given database.
 *
 * This RPC can be used to warm up the client cache by fetching key recipes
 * and server information for a given database. It is recommended to call
 * this RPC at the beginning of the client's lifecycle, prior to any other
 * data plane operations.
 *
 * The cache update is returned as a stream because the response can be too
 * large to fit into a single `CacheUpdate` message.
 *
 * @param string $formattedDatabase The database for which to retrieve the cache update. Please see
 *                                  {@see SpannerClient::databaseName()} for help formatting this field.
 */
function fetch_cache_update_sample(string $formattedDatabase): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare the request message.
    $request = (new FetchCacheUpdateRequest())
        ->setDatabase($formattedDatabase);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $spannerClient->fetchCacheUpdate($request);

        /** @var CacheUpdate $element */
        foreach ($stream->readAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedDatabase = SpannerClient::databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');

    fetch_cache_update_sample($formattedDatabase);
}
// [END spanner_v1_generated_Spanner_FetchCacheUpdate_sync]
