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

// [START aiplatform_v1_generated_TensorboardService_UpdateTensorboardRun_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\TensorboardRun;
use Google\Cloud\AIPlatform\V1\UpdateTensorboardRunRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a TensorboardRun.
 *
 * @param string $tensorboardRunDisplayName User provided name of this TensorboardRun.
 *                                          This value must be unique among all TensorboardRuns
 *                                          belonging to the same parent TensorboardExperiment.
 */
function update_tensorboard_run_sample(string $tensorboardRunDisplayName): void
{
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $tensorboardRun = (new TensorboardRun())
        ->setDisplayName($tensorboardRunDisplayName);
    $request = (new UpdateTensorboardRunRequest())
        ->setUpdateMask($updateMask)
        ->setTensorboardRun($tensorboardRun);

    // Call the API and handle any network failures.
    try {
        /** @var TensorboardRun $response */
        $response = $tensorboardServiceClient->updateTensorboardRun($request);
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
    $tensorboardRunDisplayName = '[DISPLAY_NAME]';

    update_tensorboard_run_sample($tensorboardRunDisplayName);
}
// [END aiplatform_v1_generated_TensorboardService_UpdateTensorboardRun_sync]
