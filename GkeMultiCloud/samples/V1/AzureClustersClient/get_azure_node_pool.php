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

// [START gkemulticloud_v1_generated_AzureClusters_GetAzureNodePool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\AzureNodePool;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GetAzureNodePoolRequest;

/**
 * Describes a specific
 * [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool] resource.
 *
 * @param string $formattedName The name of the
 *                              [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool] resource to
 *                              describe.
 *
 *                              `AzureNodePool` names are formatted as
 *                              `projects/<project-id>/locations/<region>/azureClusters/<cluster-id>/azureNodePools/<node-pool-id>`.
 *
 *                              See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                              for more details on Google Cloud resource names. Please see
 *                              {@see AzureClustersClient::azureNodePoolName()} for help formatting this field.
 */
function get_azure_node_pool_sample(string $formattedName): void
{
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $request = (new GetAzureNodePoolRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AzureNodePool $response */
        $response = $azureClustersClient->getAzureNodePool($request);
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
    $formattedName = AzureClustersClient::azureNodePoolName(
        '[PROJECT]',
        '[LOCATION]',
        '[AZURE_CLUSTER]',
        '[AZURE_NODE_POOL]'
    );

    get_azure_node_pool_sample($formattedName);
}
// [END gkemulticloud_v1_generated_AzureClusters_GetAzureNodePool_sync]
