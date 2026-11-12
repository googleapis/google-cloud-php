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

// [START discoveryengine_v1_generated_AssistantService_CreateAssistant_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Assistant;
use Google\Cloud\DiscoveryEngine\V1\Client\AssistantServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateAssistantRequest;

/**
 * Creates an [Assistant][google.cloud.discoveryengine.v1.Assistant].
 *
 * @param string $formattedParent      The parent resource name.
 *                                     Format:
 *                                     `projects/{project}/locations/{location}/collections/{collection}/engines/{engine}`
 *                                     Please see {@see AssistantServiceClient::engineName()} for help formatting this field.
 * @param string $assistantDisplayName The assistant display name.
 *
 *                                     It must be a UTF-8 encoded string with a length limit of 128 characters.
 * @param string $assistantId          The ID to use for the
 *                                     [Assistant][google.cloud.discoveryengine.v1.Assistant], which will become
 *                                     the final component of the
 *                                     [Assistant][google.cloud.discoveryengine.v1.Assistant]'s resource name.
 *
 *                                     This field must conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
 *                                     with a length limit of 63 characters.
 */
function create_assistant_sample(
    string $formattedParent,
    string $assistantDisplayName,
    string $assistantId
): void {
    // Create a client.
    $assistantServiceClient = new AssistantServiceClient();

    // Prepare the request message.
    $assistant = (new Assistant())
        ->setDisplayName($assistantDisplayName);
    $request = (new CreateAssistantRequest())
        ->setParent($formattedParent)
        ->setAssistant($assistant)
        ->setAssistantId($assistantId);

    // Call the API and handle any network failures.
    try {
        /** @var Assistant $response */
        $response = $assistantServiceClient->createAssistant($request);
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
    $formattedParent = AssistantServiceClient::engineName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]',
        '[ENGINE]'
    );
    $assistantDisplayName = '[DISPLAY_NAME]';
    $assistantId = '[ASSISTANT_ID]';

    create_assistant_sample($formattedParent, $assistantDisplayName, $assistantId);
}
// [END discoveryengine_v1_generated_AssistantService_CreateAssistant_sync]
