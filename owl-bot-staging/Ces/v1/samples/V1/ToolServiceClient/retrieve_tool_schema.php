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

// [START ces_v1_generated_ToolService_RetrieveToolSchema_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Ces\V1\Client\ToolServiceClient;
use Google\Cloud\Ces\V1\RetrieveToolSchemaRequest;
use Google\Cloud\Ces\V1\RetrieveToolSchemaResponse;

/**
 * Retrieve the schema of the given tool. The schema is computed on the fly
 * for the given instance of the tool.
 *
 * @param string $formattedParent The resource name of the app which the tool/toolset belongs to.
 *                                Format: `projects/{project}/locations/{location}/apps/{app}`
 *                                Please see {@see ToolServiceClient::appName()} for help formatting this field.
 */
function retrieve_tool_schema_sample(string $formattedParent): void
{
    // Create a client.
    $toolServiceClient = new ToolServiceClient();

    // Prepare the request message.
    $request = (new RetrieveToolSchemaRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var RetrieveToolSchemaResponse $response */
        $response = $toolServiceClient->retrieveToolSchema($request);
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
    $formattedParent = ToolServiceClient::appName('[PROJECT]', '[LOCATION]', '[APP]');

    retrieve_tool_schema_sample($formattedParent);
}
// [END ces_v1_generated_ToolService_RetrieveToolSchema_sync]
