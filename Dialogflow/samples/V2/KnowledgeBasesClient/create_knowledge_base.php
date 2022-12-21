<?php
/*
 * Copyright 2022 Google LLC
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

// [START dialogflow_v2_generated_KnowledgeBases_CreateKnowledgeBase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\KnowledgeBase;
use Google\Cloud\Dialogflow\V2\KnowledgeBasesClient;

/**
 * Creates a knowledge base.
 *
 * @param string $formattedParent          The project to create a knowledge base for.
 *                                         Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                         {@see KnowledgeBasesClient::projectName()} for help formatting this field.
 * @param string $knowledgeBaseDisplayName The display name of the knowledge base. The name must be 1024
 *                                         bytes or less; otherwise, the creation request fails.
 */
function create_knowledge_base_sample(
    string $formattedParent,
    string $knowledgeBaseDisplayName
): void {
    // Create a client.
    $knowledgeBasesClient = new KnowledgeBasesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $knowledgeBase = (new KnowledgeBase())
        ->setDisplayName($knowledgeBaseDisplayName);

    // Call the API and handle any network failures.
    try {
        /** @var KnowledgeBase $response */
        $response = $knowledgeBasesClient->createKnowledgeBase($formattedParent, $knowledgeBase);
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
    $formattedParent = KnowledgeBasesClient::projectName('[PROJECT]');
    $knowledgeBaseDisplayName = '[DISPLAY_NAME]';

    create_knowledge_base_sample($formattedParent, $knowledgeBaseDisplayName);
}
// [END dialogflow_v2_generated_KnowledgeBases_CreateKnowledgeBase_sync]
