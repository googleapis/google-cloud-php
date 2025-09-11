<?php
/*
 * Copyright 2025 Google LLC
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

// [START apihub_v1_generated_ApiHubPlugin_ExecutePluginInstanceAction_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiHub\V1\ActionExecutionDetail;
use Google\Cloud\ApiHub\V1\Client\ApiHubPluginClient;
use Google\Cloud\ApiHub\V1\ExecutePluginInstanceActionRequest;
use Google\Cloud\ApiHub\V1\ExecutePluginInstanceActionResponse;
use Google\Rpc\Status;

/**
 * Executes a plugin instance in the API hub.
 *
 * @param string $formattedName                 The name of the plugin instance to execute.
 *                                              Format:
 *                                              `projects/{project}/locations/{location}/plugins/{plugin}/instances/{instance}`
 *                                              Please see {@see ApiHubPluginClient::pluginInstanceName()} for help formatting this field.
 * @param string $actionExecutionDetailActionId The action id of the plugin to execute.
 */
function execute_plugin_instance_action_sample(
    string $formattedName,
    string $actionExecutionDetailActionId
): void {
    // Create a client.
    $apiHubPluginClient = new ApiHubPluginClient();

    // Prepare the request message.
    $actionExecutionDetail = (new ActionExecutionDetail())
        ->setActionId($actionExecutionDetailActionId);
    $request = (new ExecutePluginInstanceActionRequest())
        ->setName($formattedName)
        ->setActionExecutionDetail($actionExecutionDetail);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiHubPluginClient->executePluginInstanceAction($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExecutePluginInstanceActionResponse $result */
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
    $formattedName = ApiHubPluginClient::pluginInstanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[PLUGIN]',
        '[INSTANCE]'
    );
    $actionExecutionDetailActionId = '[ACTION_ID]';

    execute_plugin_instance_action_sample($formattedName, $actionExecutionDetailActionId);
}
// [END apihub_v1_generated_ApiHubPlugin_ExecutePluginInstanceAction_sync]
