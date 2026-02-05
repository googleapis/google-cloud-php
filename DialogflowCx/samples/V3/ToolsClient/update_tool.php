<?php
/*
 * Copyright 2026 Google LLC
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

// [START dialogflow_v3_generated_Tools_UpdateTool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\ToolsClient;
use Google\Cloud\Dialogflow\Cx\V3\Tool;
use Google\Cloud\Dialogflow\Cx\V3\UpdateToolRequest;

/**
 * Update the specified [Tool][google.cloud.dialogflow.cx.v3.Tool].
 *
 * @param string $toolDisplayName The human-readable name of the Tool, unique within an agent.
 * @param string $toolDescription High level description of the Tool and its usage.
 */
function update_tool_sample(string $toolDisplayName, string $toolDescription): void
{
    // Create a client.
    $toolsClient = new ToolsClient();

    // Prepare the request message.
    $tool = (new Tool())
        ->setDisplayName($toolDisplayName)
        ->setDescription($toolDescription);
    $request = (new UpdateToolRequest())
        ->setTool($tool);

    // Call the API and handle any network failures.
    try {
        /** @var Tool $response */
        $response = $toolsClient->updateTool($request);
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
    $toolDisplayName = '[DISPLAY_NAME]';
    $toolDescription = '[DESCRIPTION]';

    update_tool_sample($toolDisplayName, $toolDescription);
}
// [END dialogflow_v3_generated_Tools_UpdateTool_sync]
