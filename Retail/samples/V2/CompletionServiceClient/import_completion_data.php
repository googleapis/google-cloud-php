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

// [START retail_v2_generated_CompletionService_ImportCompletionData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\BigQuerySource;
use Google\Cloud\Retail\V2\CompletionDataInputConfig;
use Google\Cloud\Retail\V2\CompletionServiceClient;
use Google\Cloud\Retail\V2\ImportCompletionDataResponse;
use Google\Rpc\Status;

/**
 * Bulk import of processed completion dataset.
 *
 * Request processing is asynchronous. Partial updating is not supported.
 *
 * The operation is successfully finished only after the imported suggestions
 * are indexed successfully and ready for serving. The process takes hours.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 *
 * @param string $formattedParent                    The catalog which the suggestions dataset belongs to.
 *
 *                                                   Format: `projects/1234/locations/global/catalogs/default_catalog`. Please see
 *                                                   {@see CompletionServiceClient::catalogName()} for help formatting this field.
 * @param string $inputConfigBigQuerySourceDatasetId The BigQuery data set to copy the data from with a length limit
 *                                                   of 1,024 characters.
 * @param string $inputConfigBigQuerySourceTableId   The BigQuery table to copy the data from with a length limit of
 *                                                   1,024 characters.
 */
function import_completion_data_sample(
    string $formattedParent,
    string $inputConfigBigQuerySourceDatasetId,
    string $inputConfigBigQuerySourceTableId
): void {
    // Create a client.
    $completionServiceClient = new CompletionServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfigBigQuerySource = (new BigQuerySource())
        ->setDatasetId($inputConfigBigQuerySourceDatasetId)
        ->setTableId($inputConfigBigQuerySourceTableId);
    $inputConfig = (new CompletionDataInputConfig())
        ->setBigQuerySource($inputConfigBigQuerySource);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $completionServiceClient->importCompletionData($formattedParent, $inputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportCompletionDataResponse $result */
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
    $formattedParent = CompletionServiceClient::catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
    $inputConfigBigQuerySourceDatasetId = '[DATASET_ID]';
    $inputConfigBigQuerySourceTableId = '[TABLE_ID]';

    import_completion_data_sample(
        $formattedParent,
        $inputConfigBigQuerySourceDatasetId,
        $inputConfigBigQuerySourceTableId
    );
}
// [END retail_v2_generated_CompletionService_ImportCompletionData_sync]
