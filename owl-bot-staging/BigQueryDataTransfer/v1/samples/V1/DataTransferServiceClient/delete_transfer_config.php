<?php
/*
 * Copyright 2024 Google LLC
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

// [START bigquerydatatransfer_v1_generated_DataTransferService_DeleteTransferConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataTransfer\V1\Client\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferConfigRequest;

/**
 * Deletes a data transfer configuration, including any associated transfer
 * runs and logs.
 *
 * @param string $formattedName The field will contain name of the resource requested, for
 *                              example: `projects/{project_id}/transferConfigs/{config_id}` or
 *                              `projects/{project_id}/locations/{location_id}/transferConfigs/{config_id}`
 *                              Please see {@see DataTransferServiceClient::transferConfigName()} for help formatting this field.
 */
function delete_transfer_config_sample(string $formattedName): void
{
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Prepare the request message.
    $request = (new DeleteTransferConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $dataTransferServiceClient->deleteTransferConfig($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = DataTransferServiceClient::transferConfigName('[PROJECT]', '[TRANSFER_CONFIG]');

    delete_transfer_config_sample($formattedName);
}
// [END bigquerydatatransfer_v1_generated_DataTransferService_DeleteTransferConfig_sync]
