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

// [START firestore_v1_generated_Firestore_RunAggregationQuery_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Firestore\V1\FirestoreClient;
use Google\Cloud\Firestore\V1\RunAggregationQueryResponse;

/**
 * Runs an aggregation query.
 *
 * Rather than producing [Document][google.firestore.v1.Document] results like
 * [Firestore.RunQuery][google.firestore.v1.Firestore.RunQuery], this API
 * allows running an aggregation to produce a series of
 * [AggregationResult][google.firestore.v1.AggregationResult] server-side.
 *
 * High-Level Example:
 *
 * ```
 * -- Return the number of documents in table given a filter.
 * SELECT COUNT(*) FROM ( SELECT * FROM k where a = true );
 * ```
 *
 * @param string $parent The parent resource name. In the format:
 *                       `projects/{project_id}/databases/{database_id}/documents` or
 *                       `projects/{project_id}/databases/{database_id}/documents/{document_path}`.
 *                       For example:
 *                       `projects/my-project/databases/my-database/documents` or
 *                       `projects/my-project/databases/my-database/documents/chatrooms/my-chatroom`
 */
function run_aggregation_query_sample(string $parent): void
{
    // Create a client.
    $firestoreClient = new FirestoreClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $firestoreClient->runAggregationQuery($parent);

        /** @var RunAggregationQueryResponse $element */
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
    $parent = '[PARENT]';

    run_aggregation_query_sample($parent);
}
// [END firestore_v1_generated_Firestore_RunAggregationQuery_sync]
