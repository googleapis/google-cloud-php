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

// [START aiplatform_v1_generated_TensorboardService_CreateTensorboardExperiment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\CreateTensorboardExperimentRequest;
use Google\Cloud\AIPlatform\V1\TensorboardExperiment;

/**
 * Creates a TensorboardExperiment.
 *
 * @param string $formattedParent         The resource name of the Tensorboard to create the
 *                                        TensorboardExperiment in. Format:
 *                                        `projects/{project}/locations/{location}/tensorboards/{tensorboard}`
 *                                        Please see {@see TensorboardServiceClient::tensorboardExperimentName()} for help formatting this field.
 * @param string $tensorboardExperimentId The ID to use for the Tensorboard experiment, which becomes the
 *                                        final component of the Tensorboard experiment's resource name.
 *
 *                                        This value should be 1-128 characters, and valid characters
 *                                        are `/[a-z][0-9]-/`.
 */
function create_tensorboard_experiment_sample(
    string $formattedParent,
    string $tensorboardExperimentId
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare the request message.
    $request = (new CreateTensorboardExperimentRequest())
        ->setParent($formattedParent)
        ->setTensorboardExperimentId($tensorboardExperimentId);

    // Call the API and handle any network failures.
    try {
        /** @var TensorboardExperiment $response */
        $response = $tensorboardServiceClient->createTensorboardExperiment($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedParent = TensorboardServiceClient::tensorboardExperimentName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]'
    );
    $tensorboardExperimentId = '[TENSORBOARD_EXPERIMENT_ID]';

    create_tensorboard_experiment_sample($formattedParent, $tensorboardExperimentId);
}
// [END aiplatform_v1_generated_TensorboardService_CreateTensorboardExperiment_sync]
