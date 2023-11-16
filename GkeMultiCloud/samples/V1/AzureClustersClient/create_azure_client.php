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

// [START gkemulticloud_v1_generated_AzureClusters_CreateAzureClient_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AzureClient;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\CreateAzureClientRequest;
use Google\Rpc\Status;

/**
 * Creates a new [AzureClient][google.cloud.gkemulticloud.v1.AzureClient]
 * resource on a given Google Cloud project and region.
 *
 * `AzureClient` resources hold client authentication
 * information needed by the Anthos Multicloud API to manage Azure resources
 * on your Azure subscription on your behalf.
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent          The parent location where this
 *                                         [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resource will be
 *                                         created.
 *
 *                                         Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                         See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                         for more details on Google Cloud resource names. Please see
 *                                         {@see AzureClustersClient::locationName()} for help formatting this field.
 * @param string $azureClientTenantId      The Azure Active Directory Tenant ID.
 * @param string $azureClientApplicationId The Azure Active Directory Application ID.
 * @param string $azureClientId            A client provided ID the resource. Must be unique within the
 *                                         parent resource.
 *
 *                                         The provided ID will be part of the
 *                                         [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resource name
 *                                         formatted as
 *                                         `projects/<project-id>/locations/<region>/azureClients/<client-id>`.
 *
 *                                         Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 63 characters.
 */
function create_azure_client_sample(
    string $formattedParent,
    string $azureClientTenantId,
    string $azureClientApplicationId,
    string $azureClientId
): void {
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $azureClient = (new AzureClient())
        ->setTenantId($azureClientTenantId)
        ->setApplicationId($azureClientApplicationId);
    $request = (new CreateAzureClientRequest())
        ->setParent($formattedParent)
        ->setAzureClient($azureClient)
        ->setAzureClientId($azureClientId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $azureClustersClient->createAzureClient($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AzureClient $result */
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
    $formattedParent = AzureClustersClient::locationName('[PROJECT]', '[LOCATION]');
    $azureClientTenantId = '[TENANT_ID]';
    $azureClientApplicationId = '[APPLICATION_ID]';
    $azureClientId = '[AZURE_CLIENT_ID]';

    create_azure_client_sample(
        $formattedParent,
        $azureClientTenantId,
        $azureClientApplicationId,
        $azureClientId
    );
}
// [END gkemulticloud_v1_generated_AzureClusters_CreateAzureClient_sync]
