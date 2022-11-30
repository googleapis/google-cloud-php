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

// [START datastore_v1_generated_Datastore_Lookup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Datastore\V1\DatastoreClient;
use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Datastore\V1\LookupResponse;

/**
 * Looks up entities by key.
 *
 * @param string $projectId The ID of the project against which to make the request.
 */
function lookup_sample(string $projectId): void
{
    // Create a client.
    $datastoreClient = new DatastoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $keys = [new Key()];

    // Call the API and handle any network failures.
    try {
        /** @var LookupResponse $response */
        $response = $datastoreClient->lookup($projectId, $keys);
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
    $projectId = '[PROJECT_ID]';

    lookup_sample($projectId);
}
// [END datastore_v1_generated_Datastore_Lookup_sync]
