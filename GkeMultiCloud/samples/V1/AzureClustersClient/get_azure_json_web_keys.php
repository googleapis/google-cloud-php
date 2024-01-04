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

// [START gkemulticloud_v1_generated_AzureClusters_GetAzureJsonWebKeys_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeMultiCloud\V1\AzureJsonWebKeys;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\GetAzureJsonWebKeysRequest;

/**
 * Gets the public component of the cluster signing keys in
 * JSON Web Key format.
 *
 * @param string $formattedAzureCluster The AzureCluster, which owns the JsonWebKeys.
 *                                      Format:
 *                                      projects/<project-id>/locations/<region>/azureClusters/<cluster-id>
 *                                      Please see {@see AzureClustersClient::azureClusterName()} for help formatting this field.
 */
function get_azure_json_web_keys_sample(string $formattedAzureCluster): void
{
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $request = (new GetAzureJsonWebKeysRequest())
        ->setAzureCluster($formattedAzureCluster);

    // Call the API and handle any network failures.
    try {
        /** @var AzureJsonWebKeys $response */
        $response = $azureClustersClient->getAzureJsonWebKeys($request);
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
    $formattedAzureCluster = AzureClustersClient::azureClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[AZURE_CLUSTER]'
    );

    get_azure_json_web_keys_sample($formattedAzureCluster);
}
// [END gkemulticloud_v1_generated_AzureClusters_GetAzureJsonWebKeys_sync]
