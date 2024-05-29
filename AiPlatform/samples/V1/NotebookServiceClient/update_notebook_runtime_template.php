<?php
/*
 * Copyright 2024 Google LLC
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

// [START aiplatform_v1_generated_NotebookService_UpdateNotebookRuntimeTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\NotebookServiceClient;
use Google\Cloud\AIPlatform\V1\NotebookRuntimeTemplate;
use Google\Cloud\AIPlatform\V1\UpdateNotebookRuntimeTemplateRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a NotebookRuntimeTemplate.
 *
 * @param string $notebookRuntimeTemplateDisplayName The display name of the NotebookRuntimeTemplate.
 *                                                   The name can be up to 128 characters long and can consist of any UTF-8
 *                                                   characters.
 */
function update_notebook_runtime_template_sample(string $notebookRuntimeTemplateDisplayName): void
{
    // Create a client.
    $notebookServiceClient = new NotebookServiceClient();

    // Prepare the request message.
    $notebookRuntimeTemplate = (new NotebookRuntimeTemplate())
        ->setDisplayName($notebookRuntimeTemplateDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdateNotebookRuntimeTemplateRequest())
        ->setNotebookRuntimeTemplate($notebookRuntimeTemplate)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var NotebookRuntimeTemplate $response */
        $response = $notebookServiceClient->updateNotebookRuntimeTemplate($request);
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
    $notebookRuntimeTemplateDisplayName = '[DISPLAY_NAME]';

    update_notebook_runtime_template_sample($notebookRuntimeTemplateDisplayName);
}
// [END aiplatform_v1_generated_NotebookService_UpdateNotebookRuntimeTemplate_sync]
