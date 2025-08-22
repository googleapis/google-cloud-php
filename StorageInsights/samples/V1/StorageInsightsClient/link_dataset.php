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

// [START storageinsights_v1_generated_StorageInsights_LinkDataset_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\StorageInsights\V1\Client\StorageInsightsClient;
use Google\Cloud\StorageInsights\V1\LinkDatasetRequest;
use Google\Cloud\StorageInsights\V1\LinkDatasetResponse;
use Google\Rpc\Status;

/**
 * Links a dataset to BigQuery in a given project for a given location.
 *
 * @param string $formattedName Name of the resource
 *                              Please see {@see StorageInsightsClient::datasetConfigName()} for help formatting this field.
 */
function link_dataset_sample(string $formattedName): void
{
    // Create a client.
    $storageInsightsClient = new StorageInsightsClient();

    // Prepare the request message.
    $request = (new LinkDatasetRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $storageInsightsClient->linkDataset($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var LinkDatasetResponse $result */
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
    $formattedName = StorageInsightsClient::datasetConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATASET_CONFIG]'
    );

    link_dataset_sample($formattedName);
}
// [END storageinsights_v1_generated_StorageInsights_LinkDataset_sync]
