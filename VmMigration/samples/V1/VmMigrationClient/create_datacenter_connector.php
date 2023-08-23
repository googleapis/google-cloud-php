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

// [START vmmigration_v1_generated_VmMigration_CreateDatacenterConnector_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\CreateDatacenterConnectorRequest;
use Google\Cloud\VMMigration\V1\DatacenterConnector;
use Google\Rpc\Status;

/**
 * Creates a new DatacenterConnector in a given Source.
 *
 * @param string $formattedParent       The DatacenterConnector's parent.
 *                                      The Source in where the new DatacenterConnector will be created.
 *                                      For example:
 *                                      `projects/my-project/locations/us-central1/sources/my-source`
 *                                      Please see {@see VmMigrationClient::sourceName()} for help formatting this field.
 * @param string $datacenterConnectorId The datacenterConnector identifier.
 */
function create_datacenter_connector_sample(
    string $formattedParent,
    string $datacenterConnectorId
): void {
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $datacenterConnector = new DatacenterConnector();
    $request = (new CreateDatacenterConnectorRequest())
        ->setParent($formattedParent)
        ->setDatacenterConnectorId($datacenterConnectorId)
        ->setDatacenterConnector($datacenterConnector);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmMigrationClient->createDatacenterConnector($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DatacenterConnector $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = VmMigrationClient::sourceName('[PROJECT]', '[LOCATION]', '[SOURCE]');
    $datacenterConnectorId = '[DATACENTER_CONNECTOR_ID]';

    create_datacenter_connector_sample($formattedParent, $datacenterConnectorId);
}
// [END vmmigration_v1_generated_VmMigration_CreateDatacenterConnector_sync]
