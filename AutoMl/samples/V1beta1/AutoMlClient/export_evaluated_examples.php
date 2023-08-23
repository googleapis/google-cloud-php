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

// [START automl_v1beta1_generated_AutoMl_ExportEvaluatedExamples_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Cloud\AutoMl\V1beta1\ExportEvaluatedExamplesOutputConfig;
use Google\Rpc\Status;

/**
 * Exports examples on which the model was evaluated (i.e. which were in the
 * TEST set of the dataset the model was created from), together with their
 * ground truth annotations and the annotations created (predicted) by the
 * model.
 * The examples, ground truth and predictions are exported in the state
 * they were at the moment the model was evaluated.
 *
 * This export is available only for 30 days since the model evaluation is
 * created.
 *
 * Currently only available for Tables.
 *
 * Returns an empty response in the
 * [response][google.longrunning.Operation.response] field when it completes.
 *
 * @param string $formattedName The resource name of the model whose evaluated examples are to
 *                              be exported. Please see
 *                              {@see AutoMlClient::modelName()} for help formatting this field.
 */
function export_evaluated_examples_sample(string $formattedName): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $outputConfig = new ExportEvaluatedExamplesOutputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autoMlClient->exportEvaluatedExamples($formattedName, $outputConfig);
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
    $formattedName = AutoMlClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    export_evaluated_examples_sample($formattedName);
}
// [END automl_v1beta1_generated_AutoMl_ExportEvaluatedExamples_sync]
