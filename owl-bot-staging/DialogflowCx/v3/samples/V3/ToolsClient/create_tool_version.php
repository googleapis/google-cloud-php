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

// [START dialogflow_v3_generated_Tools_CreateToolVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\ToolsClient;
use Google\Cloud\Dialogflow\Cx\V3\CreateToolVersionRequest;
use Google\Cloud\Dialogflow\Cx\V3\Tool;
use Google\Cloud\Dialogflow\Cx\V3\ToolVersion;

/**
 * Creates a version for the specified
 * [Tool][google.cloud.dialogflow.cx.v3.Tool].
 *
 * @param string $formattedParent            The tool to create a version for.
 *                                           Format:
 *                                           `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/tools/<ToolID>`. Please see
 *                                           {@see ToolsClient::toolName()} for help formatting this field.
 * @param string $toolVersionDisplayName     The display name of the tool version.
 * @param string $toolVersionToolDisplayName The human-readable name of the Tool, unique within an agent.
 * @param string $toolVersionToolDescription High level description of the Tool and its usage.
 */
function create_tool_version_sample(
    string $formattedParent,
    string $toolVersionDisplayName,
    string $toolVersionToolDisplayName,
    string $toolVersionToolDescription
): void {
    // Create a client.
    $toolsClient = new ToolsClient();

    // Prepare the request message.
    $toolVersionTool = (new Tool())
        ->setDisplayName($toolVersionToolDisplayName)
        ->setDescription($toolVersionToolDescription);
    $toolVersion = (new ToolVersion())
        ->setDisplayName($toolVersionDisplayName)
        ->setTool($toolVersionTool);
    $request = (new CreateToolVersionRequest())
        ->setParent($formattedParent)
        ->setToolVersion($toolVersion);

    // Call the API and handle any network failures.
    try {
        /** @var ToolVersion $response */
        $response = $toolsClient->createToolVersion($request);
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
    $formattedParent = ToolsClient::toolName('[PROJECT]', '[LOCATION]', '[AGENT]', '[TOOL]');
    $toolVersionDisplayName = '[DISPLAY_NAME]';
    $toolVersionToolDisplayName = '[DISPLAY_NAME]';
    $toolVersionToolDescription = '[DESCRIPTION]';

    create_tool_version_sample(
        $formattedParent,
        $toolVersionDisplayName,
        $toolVersionToolDisplayName,
        $toolVersionToolDescription
    );
}
// [END dialogflow_v3_generated_Tools_CreateToolVersion_sync]
