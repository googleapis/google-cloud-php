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

// [START aiplatform_v1_generated_TensorboardService_CreateTensorboardRun_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\CreateTensorboardRunRequest;
use Google\Cloud\AIPlatform\V1\TensorboardRun;

/**
 * Creates a TensorboardRun.
 *
 * @param string $formattedParent           The resource name of the TensorboardExperiment to create the
 *                                          TensorboardRun in. Format:
 *                                          `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}`
 *                                          Please see {@see TensorboardServiceClient::tensorboardRunName()} for help formatting this field.
 * @param string $tensorboardRunDisplayName User provided name of this TensorboardRun.
 *                                          This value must be unique among all TensorboardRuns
 *                                          belonging to the same parent TensorboardExperiment.
 * @param string $tensorboardRunId          The ID to use for the Tensorboard run, which becomes the final
 *                                          component of the Tensorboard run's resource name.
 *
 *                                          This value should be 1-128 characters, and valid characters
 *                                          are `/[a-z][0-9]-/`.
 */
function create_tensorboard_run_sample(
    string $formattedParent,
    string $tensorboardRunDisplayName,
    string $tensorboardRunId
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare the request message.
    $tensorboardRun = (new TensorboardRun())
        ->setDisplayName($tensorboardRunDisplayName);
    $request = (new CreateTensorboardRunRequest())
        ->setParent($formattedParent)
        ->setTensorboardRun($tensorboardRun)
        ->setTensorboardRunId($tensorboardRunId);

    // Call the API and handle any network failures.
    try {
        /** @var TensorboardRun $response */
        $response = $tensorboardServiceClient->createTensorboardRun($request);
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
    $formattedParent = TensorboardServiceClient::tensorboardRunName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]'
    );
    $tensorboardRunDisplayName = '[DISPLAY_NAME]';
    $tensorboardRunId = '[TENSORBOARD_RUN_ID]';

    create_tensorboard_run_sample($formattedParent, $tensorboardRunDisplayName, $tensorboardRunId);
}
// [END aiplatform_v1_generated_TensorboardService_CreateTensorboardRun_sync]
