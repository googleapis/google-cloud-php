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

// [START vmmigration_v1_generated_VmMigration_GetSource_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\GetSourceRequest;
use Google\Cloud\VMMigration\V1\Source;

/**
 * Gets details of a single Source.
 *
 * @param string $formattedName The Source name. Please see
 *                              {@see VmMigrationClient::sourceName()} for help formatting this field.
 */
function get_source_sample(string $formattedName): void
{
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $request = (new GetSourceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Source $response */
        $response = $vmMigrationClient->getSource($request);
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
    $formattedName = VmMigrationClient::sourceName('[PROJECT]', '[LOCATION]', '[SOURCE]');

    get_source_sample($formattedName);
}
// [END vmmigration_v1_generated_VmMigration_GetSource_sync]
