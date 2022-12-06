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

// [START bigtable_v2_generated_Bigtable_PingAndWarm_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\PingAndWarmResponse;

/**
 * Warm up associated instance metadata for this connection.
 * This call is not required but may be useful for connection keep-alive.
 *
 * @param string $formattedName The unique name of the instance to check permissions for as well as
 *                              respond. Values are of the form `projects/<project>/instances/<instance>`. Please see
 *                              {@see BigtableClient::instanceName()} for help formatting this field.
 */
function ping_and_warm_sample(string $formattedName): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Call the API and handle any network failures.
    try {
        /** @var PingAndWarmResponse $response */
        $response = $bigtableClient->pingAndWarm($formattedName);
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
    $formattedName = BigtableClient::instanceName('[PROJECT]', '[INSTANCE]');

    ping_and_warm_sample($formattedName);
}
// [END bigtable_v2_generated_Bigtable_PingAndWarm_sync]
