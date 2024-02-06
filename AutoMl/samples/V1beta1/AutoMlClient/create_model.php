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

// [START automl_v1beta1_generated_AutoMl_CreateModel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1beta1\AutoMlClient;
use Google\Cloud\AutoMl\V1beta1\Model;
use Google\Rpc\Status;

/**
 * Creates a model.
 * Returns a Model in the [response][google.longrunning.Operation.response]
 * field when it completes.
 * When you create a model, several model evaluations are created for it:
 * a global evaluation, and one evaluation for each annotation spec.
 *
 * @param string $formattedParent Resource name of the parent project where the model is being created. Please see
 *                                {@see AutoMlClient::locationName()} for help formatting this field.
 */
function create_model_sample(string $formattedParent): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $model = new Model();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $autoMlClient->createModel($formattedParent, $model);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Model $result */
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
    $formattedParent = AutoMlClient::locationName('[PROJECT]', '[LOCATION]');

    create_model_sample($formattedParent);
}
// [END automl_v1beta1_generated_AutoMl_CreateModel_sync]
