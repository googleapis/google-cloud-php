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

// [START oracledatabase_v1_generated_OracleDatabase_GetCloudExadataInfrastructure_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CloudExadataInfrastructure;
use Google\Cloud\OracleDatabase\V1\GetCloudExadataInfrastructureRequest;

/**
 * Gets details of a single Exadata Infrastructure.
 *
 * @param string $formattedName The name of the Cloud Exadata Infrastructure in the following
 *                              format:
 *                              projects/{project}/locations/{location}/cloudExadataInfrastructures/{cloud_exadata_infrastructure}. Please see
 *                              {@see OracleDatabaseClient::cloudExadataInfrastructureName()} for help formatting this field.
 */
function get_cloud_exadata_infrastructure_sample(string $formattedName): void
{
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $request = (new GetCloudExadataInfrastructureRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CloudExadataInfrastructure $response */
        $response = $oracleDatabaseClient->getCloudExadataInfrastructure($request);
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
    $formattedName = OracleDatabaseClient::cloudExadataInfrastructureName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLOUD_EXADATA_INFRASTRUCTURE]'
    );

    get_cloud_exadata_infrastructure_sample($formattedName);
}
// [END oracledatabase_v1_generated_OracleDatabase_GetCloudExadataInfrastructure_sync]
