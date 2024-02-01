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

// [START automl_v1beta1_generated_AutoMl_ExportModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Rpc\Status;

/**
 * Exports a trained, "export-able", model to a user specified Google Cloud
 * Storage location. A model is considered export-able if and only if it has
 * an export format defined for it in
 *
 * [ModelExportOutputConfig][google.cloud.automl.v1beta1.ModelExportOutputConfig].
 *
 * Returns an empty response in the
 * [response][google.longrunning.Operation.response] field when it completes.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function export_model_sample(): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autoMlClient->exportModel();
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END automl_v1beta1_generated_AutoMl_ExportModel_sync]
