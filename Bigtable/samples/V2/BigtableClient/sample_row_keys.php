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

// [START bigtable_v2_generated_Bigtable_SampleRowKeys_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\SampleRowKeysResponse;

/**
 * Returns a sample of row keys in the table. The returned row keys will
 * delimit contiguous sections of the table of approximately equal size,
 * which can be used to break up the data for distributed tasks like
 * mapreduces.
 *
 * @param string $formattedTableName The unique name of the table from which to sample row keys.
 *                                   Values are of the form
 *                                   `projects/<project>/instances/<instance>/tables/<table>`. Please see
 *                                   {@see BigtableClient::tableName()} for help formatting this field.
 */
function sample_row_keys_sample(string $formattedTableName): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $bigtableClient->sampleRowKeys($formattedTableName);

        /** @var SampleRowKeysResponse $element */
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

    sample_row_keys_sample($formattedTableName);
}
// [END bigtable_v2_generated_Bigtable_SampleRowKeys_sync]
