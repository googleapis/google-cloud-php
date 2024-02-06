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

// [START bigtable_v2_generated_Bigtable_MutateRows_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\Mutation;

/**
 * Mutates multiple rows in a batch. Each individual row is mutated
 * atomically as in MutateRow, but the entire batch is not executed
 * atomically.
 *
 * @param string $formattedTableName The unique name of the table to which the mutations should be
 *                                   applied. Please see
 *                                   {@see BigtableClient::tableName()} for help formatting this field.
 */
function mutate_rows_sample(string $formattedTableName): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Prepare the request message.
    $entriesMutations = [new Mutation()];
    $entry = (new Entry())
        ->setMutations($entriesMutations);
    $entries = [$entry,];
    $request = (new MutateRowsRequest())
        ->setTableName($formattedTableName)
        ->setEntries($entries);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $bigtableClient->mutateRows($request);

        /** @var MutateRowsResponse $element */
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
    $formattedTableName = BigtableClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');

    mutate_rows_sample($formattedTableName);
}
// [END bigtable_v2_generated_Bigtable_MutateRows_sync]
