<?php
/*
 * Copyright 2023 Google LLC
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

// [START clouddeploy_v1_generated_CloudDeploy_CancelAutomationRun_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Deploy\V1\CancelAutomationRunRequest;
use Google\Cloud\Deploy\V1\CancelAutomationRunResponse;
use Google\Cloud\Deploy\V1\Client\CloudDeployClient;

/**
 * Cancels an AutomationRun. The `state` of the `AutomationRun` after
 * cancelling is `CANCELLED`. `CancelAutomationRun` can be called on
 * AutomationRun in the state `IN_PROGRESS` and `PENDING`; AutomationRun
 * in a different state returns an `FAILED_PRECONDITION` error.
 *
 * @param string $formattedName Name of the `AutomationRun`. Format is
 *                              `projects/{project}/locations/{location}/deliveryPipelines/{delivery_pipeline}/automationRuns/{automation_run}`. Please see
 *                              {@see CloudDeployClient::automationRunName()} for help formatting this field.
 */
function cancel_automation_run_sample(string $formattedName): void
{
    // Create a client.
    $cloudDeployClient = new CloudDeployClient();

    // Prepare the request message.
    $request = (new CancelAutomationRunRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CancelAutomationRunResponse $response */
        $response = $cloudDeployClient->cancelAutomationRun($request);
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
    $formattedName = CloudDeployClient::automationRunName(
        '[PROJECT]',
        '[LOCATION]',
        '[DELIVERY_PIPELINE]',
        '[AUTOMATION_RUN]'
    );

    cancel_automation_run_sample($formattedName);
}
// [END clouddeploy_v1_generated_CloudDeploy_CancelAutomationRun_sync]
