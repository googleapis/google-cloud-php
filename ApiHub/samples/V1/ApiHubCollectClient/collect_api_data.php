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

// [START apihub_v1_generated_ApiHubCollect_CollectApiData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiHub\V1\ApiData;
use Google\Cloud\ApiHub\V1\Client\ApiHubCollectClient;
use Google\Cloud\ApiHub\V1\CollectApiDataRequest;
use Google\Cloud\ApiHub\V1\CollectApiDataResponse;
use Google\Cloud\ApiHub\V1\CollectionType;
use Google\Rpc\Status;

/**
 * Collect API data from a source and push it to Hub's collect layer.
 *
 * @param string $formattedLocation       The regional location of the API hub instance and its resources.
 *                                        Format: `projects/{project}/locations/{location}`
 *                                        Please see {@see ApiHubCollectClient::locationName()} for help formatting this field.
 * @param int    $collectionType          The type of collection. Applies to all entries in
 *                                        [api_data][google.cloud.apihub.v1.CollectApiDataRequest.api_data].
 * @param string $formattedPluginInstance The plugin instance collecting the API data.
 *                                        Format:
 *                                        `projects/{project}/locations/{location}/plugins/{plugin}/instances/{instance}`. Please see
 *                                        {@see ApiHubCollectClient::pluginInstanceName()} for help formatting this field.
 * @param string $actionId                The action ID to be used for collecting the API data.
 *                                        This should map to one of the action IDs specified
 *                                        in action configs in the plugin.
 */
function collect_api_data_sample(
    string $formattedLocation,
    int $collectionType,
    string $formattedPluginInstance,
    string $actionId
): void {
    // Create a client.
    $apiHubCollectClient = new ApiHubCollectClient();

    // Prepare the request message.
    $apiData = new ApiData();
    $request = (new CollectApiDataRequest())
        ->setLocation($formattedLocation)
        ->setCollectionType($collectionType)
        ->setPluginInstance($formattedPluginInstance)
        ->setActionId($actionId)
        ->setApiData($apiData);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiHubCollectClient->collectApiData($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CollectApiDataResponse $result */
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
    $formattedLocation = ApiHubCollectClient::locationName('[PROJECT]', '[LOCATION]');
    $collectionType = CollectionType::COLLECTION_TYPE_UNSPECIFIED;
    $formattedPluginInstance = ApiHubCollectClient::pluginInstanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[PLUGIN]',
        '[INSTANCE]'
    );
    $actionId = '[ACTION_ID]';

    collect_api_data_sample($formattedLocation, $collectionType, $formattedPluginInstance, $actionId);
}
// [END apihub_v1_generated_ApiHubCollect_CollectApiData_sync]
