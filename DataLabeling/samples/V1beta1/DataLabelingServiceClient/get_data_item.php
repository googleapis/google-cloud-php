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

// [START datalabeling_v1beta1_generated_DataLabelingService_GetDataItem_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataLabeling\V1beta1\Client\DataLabelingServiceClient;
use Google\Cloud\DataLabeling\V1beta1\DataItem;
use Google\Cloud\DataLabeling\V1beta1\GetDataItemRequest;

/**
 * Gets a data item in a dataset by resource name. This API can be
 * called after data are imported into dataset.
 *
 * @param string $formattedName The name of the data item to get, format:
 *                              projects/{project_id}/datasets/{dataset_id}/dataItems/{data_item_id}
 *                              Please see {@see DataLabelingServiceClient::dataItemName()} for help formatting this field.
 */
function get_data_item_sample(string $formattedName): void
{
    // Create a client.
    $dataLabelingServiceClient = new DataLabelingServiceClient();

    // Prepare the request message.
    $request = (new GetDataItemRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DataItem $response */
        $response = $dataLabelingServiceClient->getDataItem($request);
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
    $formattedName = DataLabelingServiceClient::dataItemName('[PROJECT]', '[DATASET]', '[DATA_ITEM]');

    get_data_item_sample($formattedName);
}
// [END datalabeling_v1beta1_generated_DataLabelingService_GetDataItem_sync]
