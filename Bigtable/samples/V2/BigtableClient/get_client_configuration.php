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

// [START bigtable_v2_generated_Bigtable_GetClientConfiguration_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\V2\ClientConfiguration;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\GetClientConfigurationRequest;

/**
 * This RPC is only intended to be used by the official Cloud Bigtable client
 * libraries to implement the Bigtable Session based protocol. It is subject
 * to change without notice.
 *
 * @param string $formattedInstanceName The unique name of the instance for which the client will target
 *                                      with Data API requests.
 *
 *                                      Values are of the form `projects/<project>/instances/<instance>`
 *                                      Please see {@see BigtableClient::instanceName()} for help formatting this field.
 */
function get_client_configuration_sample(string $formattedInstanceName): void
{
    // Create a client.
    $bigtableClient = new BigtableClient();

    // Prepare the request message.
    $request = (new GetClientConfigurationRequest())
        ->setInstanceName($formattedInstanceName);

    // Call the API and handle any network failures.
    try {
        /** @var ClientConfiguration $response */
        $response = $bigtableClient->getClientConfiguration($request);
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
    $formattedInstanceName = BigtableClient::instanceName('[PROJECT]', '[INSTANCE]');

    get_client_configuration_sample($formattedInstanceName);
}
// [END bigtable_v2_generated_Bigtable_GetClientConfiguration_sync]
