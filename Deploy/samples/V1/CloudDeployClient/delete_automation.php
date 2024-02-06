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

// [START clouddeploy_v1_generated_CloudDeploy_DeleteAutomation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Deploy\V1\Client\CloudDeployClient;
use Google\Cloud\Deploy\V1\DeleteAutomationRequest;
use Google\Rpc\Status;

/**
 * Deletes a single Automation resource.
 *
 * @param string $formattedName The name of the `Automation` to delete. Format should be
 *                              `projects/{project_id}/locations/{location_name}/deliveryPipelines/{pipeline_name}/automations/{automation_name}`. Please see
 *                              {@see CloudDeployClient::automationName()} for help formatting this field.
 */
function delete_automation_sample(string $formattedName): void
{
    // Create a client.
    $cloudDeployClient = new CloudDeployClient();

    // Prepare the request message.
    $request = (new DeleteAutomationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudDeployClient->deleteAutomation($request);
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
    $formattedName = CloudDeployClient::automationName(
        '[PROJECT]',
        '[LOCATION]',
        '[DELIVERY_PIPELINE]',
        '[AUTOMATION]'
    );

    delete_automation_sample($formattedName);
}
// [END clouddeploy_v1_generated_CloudDeploy_DeleteAutomation_sync]
