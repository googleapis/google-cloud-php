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

// [START spanner_v1_generated_Spanner_BatchCreateSessions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\V1\BatchCreateSessionsRequest;
use Google\Cloud\Spanner\V1\BatchCreateSessionsResponse;
use Google\Cloud\Spanner\V1\Client\SpannerClient;

/**
 * Creates multiple new sessions.
 *
 * This API can be used to initialize a session cache on the clients.
 * See https://goo.gl/TgSFN2 for best practices on session cache management.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function batch_create_sessions_sample(): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare the request message.
    $request = new BatchCreateSessionsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateSessionsResponse $response */
        $response = $spannerClient->batchCreateSessions($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END spanner_v1_generated_Spanner_BatchCreateSessions_sync]
