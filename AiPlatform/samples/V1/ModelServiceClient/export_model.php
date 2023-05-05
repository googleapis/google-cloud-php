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

// [START aiplatform_v1_generated_ModelService_ExportModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\ModelServiceClient;
use Google\Cloud\AIPlatform\V1\ExportModelRequest;
use Google\Cloud\AIPlatform\V1\ExportModelRequest\OutputConfig;
use Google\Cloud\AIPlatform\V1\ExportModelResponse;
use Google\Rpc\Status;

/**
 * Exports a trained, exportable Model to a location specified by the
 * user. A Model is considered to be exportable if it has at least one
 * [supported export
 * format][google.cloud.aiplatform.v1.Model.supported_export_formats].
 *
 * @param string $formattedName The resource name of the Model to export.
 *                              The resource name may contain version id or version alias to specify the
 *                              version, if no version is specified, the default version will be exported. Please see
 *                              {@see ModelServiceClient::modelName()} for help formatting this field.
 */
function export_model_sample(string $formattedName): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Prepare the request message.
    $outputConfig = new OutputConfig();
    $request = (new ExportModelRequest())
        ->setName($formattedName)
        ->setOutputConfig($outputConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $modelServiceClient->exportModel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportModelResponse $result */
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
    $formattedName = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    export_model_sample($formattedName);
}
// [END aiplatform_v1_generated_ModelService_ExportModel_sync]
