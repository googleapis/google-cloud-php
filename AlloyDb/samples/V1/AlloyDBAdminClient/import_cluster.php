<?php
/*
 * Copyright 2025 Google LLC
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

// [START alloydb_v1_generated_AlloyDBAdmin_ImportCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AlloyDb\V1\Client\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1\ImportClusterRequest;
use Google\Cloud\AlloyDb\V1\ImportClusterResponse;
use Google\Rpc\Status;

/**
 * Imports data to the cluster.
 * Imperative only.
 *
 * @param string $formattedName The resource name of the cluster. Please see
 *                              {@see AlloyDBAdminClient::clusterName()} for help formatting this field.
 * @param string $gcsUri        The path to the file in Google Cloud Storage where the source
 *                              file for import will be stored. The URI is in the form
 *                              `gs://bucketName/fileName`.
 */
function import_cluster_sample(string $formattedName, string $gcsUri): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Prepare the request message.
    $request = (new ImportClusterRequest())
        ->setName($formattedName)
        ->setGcsUri($gcsUri);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $alloyDBAdminClient->importCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportClusterResponse $result */
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
    $formattedName = AlloyDBAdminClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');
    $gcsUri = '[GCS_URI]';

    import_cluster_sample($formattedName, $gcsUri);
}
// [END alloydb_v1_generated_AlloyDBAdmin_ImportCluster_sync]
