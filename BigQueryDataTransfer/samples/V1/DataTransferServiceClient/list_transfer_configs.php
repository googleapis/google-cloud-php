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

// [START bigquerydatatransfer_v1_generated_DataTransferService_ListTransferConfigs_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BigQuery\DataTransfer\V1\Client\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsRequest;
use Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig;

/**
 * Returns information about all transfer configs owned by a project in the
 * specified location.
 *
 * @param string $formattedParent The BigQuery project id for which transfer configs
 *                                should be returned: `projects/{project_id}` or
 *                                `projects/{project_id}/locations/{location_id}`
 *                                Please see {@see DataTransferServiceClient::projectName()} for help formatting this field.
 */
function list_transfer_configs_sample(string $formattedParent): void
{
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Prepare the request message.
    $request = (new ListTransferConfigsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataTransferServiceClient->listTransferConfigs($request);

        /** @var TransferConfig $element */
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
    $formattedParent = DataTransferServiceClient::projectName('[PROJECT]');

    list_transfer_configs_sample($formattedParent);
}
// [END bigquerydatatransfer_v1_generated_DataTransferService_ListTransferConfigs_sync]
