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

// [START bigtable_v2_generated_Bigtable_ExecuteQuery_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ExecuteQueryRequest;
use Google\Cloud\Bigtable\V2\ExecuteQueryResponse;

/**
 * Executes a BTQL query against a particular Cloud Bigtable instance.
 *
 * @param string $formattedInstanceName The unique name of the instance against which the query should be
 *                                      executed.
 *                                      Values are of the form `projects/<project>/instances/<instance>`
 *                                      Please see {@see BigtableClient::instanceName()} for help formatting this field.
 * @param string $query                 The query string.
 */
function execute_query_sample(string $formattedInstanceName, string $query): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Prepare the request message.
    $params = [];
    $request = (new ExecuteQueryRequest())
        ->setInstanceName($formattedInstanceName)
        ->setQuery($query)
        ->setParams($params);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $bigtableClient->executeQuery($request);

        /** @var ExecuteQueryResponse $element */
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
    $formattedInstanceName = BigtableClient::instanceName('[PROJECT]', '[INSTANCE]');
    $query = '[QUERY]';

    execute_query_sample($formattedInstanceName, $query);
}
// [END bigtable_v2_generated_Bigtable_ExecuteQuery_sync]
