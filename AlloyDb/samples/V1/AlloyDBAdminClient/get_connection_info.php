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

// [START alloydb_v1_generated_AlloyDBAdmin_GetConnectionInfo_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AlloyDb\V1\Client\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\ConnectionInfo;
use Google\Cloud\AlloyDb\V1\GetConnectionInfoRequest;

/**
 * Get instance metadata used for a connection.
 *
 * @param string $formattedParent The name of the parent resource. The required format is:
 *                                projects/{project}/locations/{location}/clusters/{cluster}/instances/{instance}
 *                                Please see {@see AlloyDBAdminClient::instanceName()} for help formatting this field.
 */
function get_connection_info_sample(string $formattedParent): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare the request message.
    $request = (new GetConnectionInfoRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var ConnectionInfo $response */
        $response = $alloyDBAdminClient->getConnectionInfo($request);
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
    $formattedParent = AlloyDBAdminClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]',
        '[INSTANCE]'
    );

    get_connection_info_sample($formattedParent);
}
// [END alloydb_v1_generated_AlloyDBAdmin_GetConnectionInfo_sync]
