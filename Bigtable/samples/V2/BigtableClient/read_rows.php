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

// [START bigtable_v2_generated_Bigtable_ReadRows_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;

/**
 * Streams back the contents of all requested rows in key order, optionally
 * applying the same Reader filter to each. Depending on their size,
 * rows and cells may be broken up across multiple responses, but
 * atomicity of each row will still be preserved. See the
 * ReadRowsResponse documentation for details.
 *
 * @param string $formattedTableName The unique name of the table from which to read.
 *                                   Values are of the form
 *                                   `projects/<project>/instances/<instance>/tables/<table>`. Please see
 *                                   {@see BigtableClient::tableName()} for help formatting this field.
 */
function read_rows_sample(string $formattedTableName): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Prepare the request message.
    $request = (new ReadRowsRequest())
        ->setTableName($formattedTableName);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $bigtableClient->readRows($request);

        /** @var ReadRowsResponse $element */
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

    read_rows_sample($formattedTableName);
}
// [END bigtable_v2_generated_Bigtable_ReadRows_sync]
