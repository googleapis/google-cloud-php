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

// [START financialservices_v1_generated_AML_ExportModelMetadata_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\FinancialServices\V1\BigQueryDestination;
use Google\Cloud\FinancialServices\V1\BigQueryDestination\WriteDisposition;
use Google\Cloud\FinancialServices\V1\Client\AMLClient;
use Google\Cloud\FinancialServices\V1\ExportModelMetadataRequest;
use Google\Cloud\FinancialServices\V1\ExportModelMetadataResponse;
use Google\Rpc\Status;

/**
 * Export governance information for a Model resource. For
 * information on the exported fields, see
 * [AML output data
 * model](https://cloud.google.com/financial-services/anti-money-laundering/docs/reference/schemas/aml-output-data-model#model).
 *
 * @param string $formattedModel                                The resource name of the Model. Please see
 *                                                              {@see AMLClient::modelName()} for help formatting this field.
 * @param int    $structuredMetadataDestinationWriteDisposition Whether or not to overwrite the destination table. By default the
 *                                                              table won't be overwritten and an error will be returned if the table
 *                                                              exists and contains data.
 */
function export_model_metadata_sample(
    string $formattedModel,
    int $structuredMetadataDestinationWriteDisposition
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $structuredMetadataDestination = (new BigQueryDestination())
        ->setWriteDisposition($structuredMetadataDestinationWriteDisposition);
    $request = (new ExportModelMetadataRequest())
        ->setModel($formattedModel)
        ->setStructuredMetadataDestination($structuredMetadataDestination);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->exportModelMetadata($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportModelMetadataResponse $result */
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
    $formattedModel = AMLClient::modelName('[PROJECT_NUM]', '[LOCATION]', '[INSTANCE]', '[MODEL]');
    $structuredMetadataDestinationWriteDisposition = WriteDisposition::WRITE_DISPOSITION_UNSPECIFIED;

    export_model_metadata_sample($formattedModel, $structuredMetadataDestinationWriteDisposition);
}
// [END financialservices_v1_generated_AML_ExportModelMetadata_sync]
