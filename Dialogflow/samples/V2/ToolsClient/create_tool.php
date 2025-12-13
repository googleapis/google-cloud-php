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

// [START dialogflow_v2_generated_Tools_CreateTool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\ToolsClient;
use Google\Cloud\Dialogflow\V2\CreateToolRequest;
use Google\Cloud\Dialogflow\V2\Tool;

/**
 * Creates a tool.
 *
 * @param string $formattedParent The project/location to create tool for. Format:
 *                                `projects/<Project ID>/locations/<Location ID>`
 *                                Please see {@see ToolsClient::locationName()} for help formatting this field.
 * @param string $toolToolKey     A human readable short name of the tool, which should be unique
 *                                within the project. It should only contain letters, numbers, and
 *                                underscores, and it will be used by LLM to identify the tool.
 */
function create_tool_sample(string $formattedParent, string $toolToolKey): void
{
    // Create a client.
    $toolsClient = new ToolsClient();

    // Prepare the request message.
    $tool = (new Tool())
        ->setToolKey($toolToolKey);
    $request = (new CreateToolRequest())
        ->setParent($formattedParent)
        ->setTool($tool);

    // Call the API and handle any network failures.
    try {
        /** @var Tool $response */
        $response = $toolsClient->createTool($request);
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
    $formattedParent = ToolsClient::locationName('[PROJECT]', '[LOCATION]');
    $toolToolKey = '[TOOL_KEY]';

    create_tool_sample($formattedParent, $toolToolKey);
}
// [END dialogflow_v2_generated_Tools_CreateTool_sync]
