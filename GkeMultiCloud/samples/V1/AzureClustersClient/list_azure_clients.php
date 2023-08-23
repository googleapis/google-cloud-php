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

// [START gkemulticloud_v1_generated_AzureClusters_ListAzureClients_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\GkeMultiCloud\V1\AzureClient;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\ListAzureClientsRequest;

/**
 * Lists all [AzureClient][google.cloud.gkemulticloud.v1.AzureClient]
 * resources on a given Google Cloud project and region.
 *
 * @param string $formattedParent The parent location which owns this collection of
 *                                [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resources.
 *
 *                                Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                for more details on Google Cloud Platform resource names. Please see
 *                                {@see AzureClustersClient::locationName()} for help formatting this field.
 */
function list_azure_clients_sample(string $formattedParent): void
{
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $request = (new ListAzureClientsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $azureClustersClient->listAzureClients($request);

        /** @var AzureClient $element */
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
    $formattedParent = AzureClustersClient::locationName('[PROJECT]', '[LOCATION]');

    list_azure_clients_sample($formattedParent);
}
// [END gkemulticloud_v1_generated_AzureClusters_ListAzureClients_sync]
