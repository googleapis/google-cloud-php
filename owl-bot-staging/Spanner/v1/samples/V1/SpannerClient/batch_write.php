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

// [START spanner_v1_generated_Spanner_BatchWrite_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Spanner\V1\BatchWriteRequest\MutationGroup;
use Google\Cloud\Spanner\V1\BatchWriteResponse;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\SpannerClient;

/**
 * Batches the supplied mutation groups in a collection of efficient
 * transactions. All mutations in a group are committed atomically. However,
 * mutations across groups can be committed non-atomically in an unspecified
 * order and thus, they must be independent of each other. Partial failure is
 * possible, i.e., some groups may have been committed successfully, while
 * some may have failed. The results of individual batches are streamed into
 * the response as the batches are applied.
 *
 * BatchWrite requests are not replay protected, meaning that each mutation
 * group may be applied more than once. Replays of non-idempotent mutations
 * may have undesirable effects. For example, replays of an insert mutation
 * may produce an already exists error or if you use generated or commit
 * timestamp-based keys, it may result in additional rows being added to the
 * mutation's table. We recommend structuring your mutation groups to be
 * idempotent to avoid this issue.
 *
 * @param string $formattedSession The session in which the batch request is to be run. Please see
 *                                 {@see SpannerClient::sessionName()} for help formatting this field.
 */
function batch_write_sample(string $formattedSession): void
{
    // Create a client.
    $spannerClient = new SpannerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $mutationGroupsMutations = [new Mutation()];
    $mutationGroup = (new MutationGroup())
        ->setMutations($mutationGroupsMutations);
    $mutationGroups = [$mutationGroup,];

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $spannerClient->batchWrite($formattedSession, $mutationGroups);

        /** @var BatchWriteResponse $element */
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
    $formattedSession = SpannerClient::sessionName(
        '[PROJECT]',
        '[INSTANCE]',
        '[DATABASE]',
        '[SESSION]'
    );

    batch_write_sample($formattedSession);
}
// [END spanner_v1_generated_Spanner_BatchWrite_sync]
