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

// [START dataform_v1beta1_generated_Dataform_UpdateWorkflowConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\Cloud\Dataform\V1beta1\UpdateWorkflowConfigRequest;
use Google\Cloud\Dataform\V1beta1\WorkflowConfig;

/**
 * Updates a single WorkflowConfig.
 *
 * @param string $formattedWorkflowConfigReleaseConfig The name of the release config whose release_compilation_result
 *                                                     should be executed. Must be in the format
 *                                                     `projects/&#42;/locations/&#42;/repositories/&#42;/releaseConfigs/*`. Please see
 *                                                     {@see DataformClient::releaseConfigName()} for help formatting this field.
 */
function update_workflow_config_sample(string $formattedWorkflowConfigReleaseConfig): void
{
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $workflowConfig = (new WorkflowConfig())
        ->setReleaseConfig($formattedWorkflowConfigReleaseConfig);
    $request = (new UpdateWorkflowConfigRequest())
        ->setWorkflowConfig($workflowConfig);

    // Call the API and handle any network failures.
    try {
        /** @var WorkflowConfig $response */
        $response = $dataformClient->updateWorkflowConfig($request);
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
    $formattedWorkflowConfigReleaseConfig = DataformClient::releaseConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[RELEASE_CONFIG]'
    );

    update_workflow_config_sample($formattedWorkflowConfigReleaseConfig);
}
// [END dataform_v1beta1_generated_Dataform_UpdateWorkflowConfig_sync]
