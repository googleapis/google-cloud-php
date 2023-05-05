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

// [START aiplatform_v1_generated_VizierService_CheckTrialEarlyStoppingState_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\CheckTrialEarlyStoppingStateRequest;
use Google\Cloud\AIPlatform\V1\CheckTrialEarlyStoppingStateResponse;
use Google\Cloud\AIPlatform\V1\Client\VizierServiceClient;
use Google\Rpc\Status;

/**
 * Checks  whether a Trial should stop or not. Returns a
 * long-running operation. When the operation is successful,
 * it will contain a
 * [CheckTrialEarlyStoppingStateResponse][google.cloud.aiplatform.v1.CheckTrialEarlyStoppingStateResponse].
 *
 * @param string $formattedTrialName The Trial's name.
 *                                   Format:
 *                                   `projects/{project}/locations/{location}/studies/{study}/trials/{trial}`
 *                                   Please see {@see VizierServiceClient::trialName()} for help formatting this field.
 */
function check_trial_early_stopping_state_sample(string $formattedTrialName): void
{
    // Create a client.
    $vizierServiceClient = new VizierServiceClient();

    // Prepare the request message.
    $request = (new CheckTrialEarlyStoppingStateRequest())
        ->setTrialName($formattedTrialName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vizierServiceClient->checkTrialEarlyStoppingState($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CheckTrialEarlyStoppingStateResponse $result */
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
    $formattedTrialName = VizierServiceClient::trialName(
        '[PROJECT]',
        '[LOCATION]',
        '[STUDY]',
        '[TRIAL]'
    );

    check_trial_early_stopping_state_sample($formattedTrialName);
}
// [END aiplatform_v1_generated_VizierService_CheckTrialEarlyStoppingState_sync]
