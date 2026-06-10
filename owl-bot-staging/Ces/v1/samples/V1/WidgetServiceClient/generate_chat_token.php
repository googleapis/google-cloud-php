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

// [START ces_v1_generated_WidgetService_GenerateChatToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Ces\V1\Client\WidgetServiceClient;
use Google\Cloud\Ces\V1\GenerateChatTokenRequest;
use Google\Cloud\Ces\V1\GenerateChatTokenResponse;

/**
 * Generates a session scoped token for chat widget to authenticate with
 * Session APIs.
 *
 * @param string $formattedName       The session name to generate the chat token for.
 *                                    Format:
 *                                    projects/{project}/locations/{location}/apps/{app}/sessions/{session}
 *                                    Please see {@see WidgetServiceClient::sessionName()} for help formatting this field.
 * @param string $formattedDeployment The deployment of the app to use for the session.
 *                                    Format:
 *                                    projects/{project}/locations/{location}/apps/{app}/deployments/{deployment}
 *                                    Please see {@see WidgetServiceClient::deploymentName()} for help formatting this field.
 */
function generate_chat_token_sample(string $formattedName, string $formattedDeployment): void
{
    // Create a client.
    $widgetServiceClient = new WidgetServiceClient();

    // Prepare the request message.
    $request = (new GenerateChatTokenRequest())
        ->setName($formattedName)
        ->setDeployment($formattedDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateChatTokenResponse $response */
        $response = $widgetServiceClient->generateChatToken($request);
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
    $formattedName = WidgetServiceClient::sessionName('[PROJECT]', '[LOCATION]', '[APP]', '[SESSION]');
    $formattedDeployment = WidgetServiceClient::deploymentName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP]',
        '[DEPLOYMENT]'
    );

    generate_chat_token_sample($formattedName, $formattedDeployment);
}
// [END ces_v1_generated_WidgetService_GenerateChatToken_sync]
