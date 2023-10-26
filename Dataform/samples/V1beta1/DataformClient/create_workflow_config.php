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

// [START dataform_v1beta1_generated_Dataform_CreateWorkflowConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\Cloud\Dataform\V1beta1\CreateWorkflowConfigRequest;
use Google\Cloud\Dataform\V1beta1\WorkflowConfig;

/**
 * Creates a new WorkflowConfig in a given Repository.
 *
 * @param string $formattedParent                      The repository in which to create the workflow config. Must be in
 *                                                     the format `projects/&#42;/locations/&#42;/repositories/*`. Please see
 *                                                     {@see DataformClient::repositoryName()} for help formatting this field.
 * @param string $formattedWorkflowConfigReleaseConfig The name of the release config whose release_compilation_result
 *                                                     should be executed. Must be in the format
 *                                                     `projects/&#42;/locations/&#42;/repositories/&#42;/releaseConfigs/*`. Please see
 *                                                     {@see DataformClient::releaseConfigName()} for help formatting this field.
 * @param string $workflowConfigId                     The ID to use for the workflow config, which will become the
 *                                                     final component of the workflow config's resource name.
 */
function create_workflow_config_sample(
    string $formattedParent,
    string $formattedWorkflowConfigReleaseConfig,
    string $workflowConfigId
): void {
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $workflowConfig = (new WorkflowConfig())
        ->setReleaseConfig($formattedWorkflowConfigReleaseConfig);
    $request = (new CreateWorkflowConfigRequest())
        ->setParent($formattedParent)
        ->setWorkflowConfig($workflowConfig)
        ->setWorkflowConfigId($workflowConfigId);

    // Call the API and handle any network failures.
    try {
        /** @var WorkflowConfig $response */
        $response = $dataformClient->createWorkflowConfig($request);
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
    $formattedParent = DataformClient::repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
    $formattedWorkflowConfigReleaseConfig = DataformClient::releaseConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[RELEASE_CONFIG]'
    );
    $workflowConfigId = '[WORKFLOW_CONFIG_ID]';

    create_workflow_config_sample(
        $formattedParent,
        $formattedWorkflowConfigReleaseConfig,
        $workflowConfigId
    );
}
// [END dataform_v1beta1_generated_Dataform_CreateWorkflowConfig_sync]
