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

// [START automl_v1beta1_generated_AutoMl_UndeployModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Rpc\Status;

/**
 * Undeploys a model. If the model is not deployed this method has no effect.
 *
 * Only applicable for Text Classification, Image Object Detection and Tables;
 * all other domains manage deployment automatically.
 *
 * Returns an empty response in the
 * [response][google.longrunning.Operation.response] field when it completes.
 *
 * @param string $formattedName Resource name of the model to undeploy. Please see
 *                              {@see AutoMlClient::modelName()} for help formatting this field.
 */
function undeploy_model_sample(string $formattedName): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autoMlClient->undeployModel($formattedName);
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

    undeploy_model_sample($formattedName);
}
// [END automl_v1beta1_generated_AutoMl_UndeployModel_sync]
