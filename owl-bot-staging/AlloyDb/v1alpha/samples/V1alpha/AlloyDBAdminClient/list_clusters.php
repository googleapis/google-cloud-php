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

// [START alloydb_v1alpha_generated_AlloyDBAdmin_ListClusters_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AlloyDb\V1alpha\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1alpha\Cluster;

/**
 * Lists Clusters in a given project and location.
 *
 * @param string $formattedParent The name of the parent resource. For the required format, see the
 *                                comment on the Cluster.name field. Additionally, you can perform an
 *                                aggregated list operation by specifying a value with the following format:
 *                                * projects/{project}/locations/-
 *                                Please see {@see AlloyDBAdminClient::locationName()} for help formatting this field.
 */
function list_clusters_sample(string $formattedParent): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $alloyDBAdminClient->listClusters($formattedParent);

        /** @var Cluster $element */
        foreach ($response as $element) {
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
    $formattedParent = AlloyDBAdminClient::locationName('[PROJECT]', '[LOCATION]');

    list_clusters_sample($formattedParent);
}
// [END alloydb_v1alpha_generated_AlloyDBAdmin_ListClusters_sync]
