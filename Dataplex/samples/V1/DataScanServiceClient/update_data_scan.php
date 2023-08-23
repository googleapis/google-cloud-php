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

// [START dataplex_v1_generated_DataScanService_UpdateDataScan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\DataScanServiceClient;
use Google\Cloud\Dataplex\V1\DataScan;
use Google\Cloud\Dataplex\V1\DataSource;
use Google\Cloud\Dataplex\V1\UpdateDataScanRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a DataScan resource.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_data_scan_sample(): void
{
    // Create a client.
    $dataScanServiceClient = new DataScanServiceClient();

    // Prepare the request message.
    $dataScanData = new DataSource();
    $dataScan = (new DataScan())
        ->setData($dataScanData);
    $updateMask = new FieldMask();
    $request = (new UpdateDataScanRequest())
        ->setDataScan($dataScan)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataScanServiceClient->updateDataScan($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DataScan $result */
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
// [END dataplex_v1_generated_DataScanService_UpdateDataScan_sync]
