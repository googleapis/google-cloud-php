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

// [START apihub_v1_generated_RuntimeProjectAttachmentService_CreateRuntimeProjectAttachment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\RuntimeProjectAttachmentServiceClient;
use Google\Cloud\ApiHub\V1\CreateRuntimeProjectAttachmentRequest;
use Google\Cloud\ApiHub\V1\RuntimeProjectAttachment;

/**
 * Attaches a runtime project to the host project.
 *
 * @param string $formattedParent                                 The parent resource for the Runtime Project Attachment.
 *                                                                Format: `projects/{project}/locations/{location}`
 *                                                                Please see {@see RuntimeProjectAttachmentServiceClient::locationName()} for help formatting this field.
 * @param string $runtimeProjectAttachmentId                      The ID to use for the Runtime Project Attachment, which will
 *                                                                become the final component of the Runtime Project Attachment's name. The ID
 *                                                                must be the same as the project ID of the Google cloud project specified in
 *                                                                the runtime_project_attachment.runtime_project field.
 * @param string $formattedRuntimeProjectAttachmentRuntimeProject Immutable. Google cloud project name in the format:
 *                                                                "projects/abc" or "projects/123". As input, project name with either
 *                                                                project id or number are accepted. As output, this field will contain
 *                                                                project number. Please see
 *                                                                {@see RuntimeProjectAttachmentServiceClient::projectName()} for help formatting this field.
 */
function create_runtime_project_attachment_sample(
    string $formattedParent,
    string $runtimeProjectAttachmentId,
    string $formattedRuntimeProjectAttachmentRuntimeProject
): void {
    // Create a client.
    $runtimeProjectAttachmentServiceClient = new RuntimeProjectAttachmentServiceClient();

    // Prepare the request message.
    $runtimeProjectAttachment = (new RuntimeProjectAttachment())
        ->setRuntimeProject($formattedRuntimeProjectAttachmentRuntimeProject);
    $request = (new CreateRuntimeProjectAttachmentRequest())
        ->setParent($formattedParent)
        ->setRuntimeProjectAttachmentId($runtimeProjectAttachmentId)
        ->setRuntimeProjectAttachment($runtimeProjectAttachment);

    // Call the API and handle any network failures.
    try {
        /** @var RuntimeProjectAttachment $response */
        $response = $runtimeProjectAttachmentServiceClient->createRuntimeProjectAttachment($request);
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
    $formattedParent = RuntimeProjectAttachmentServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $runtimeProjectAttachmentId = '[RUNTIME_PROJECT_ATTACHMENT_ID]';
    $formattedRuntimeProjectAttachmentRuntimeProject = RuntimeProjectAttachmentServiceClient::projectName(
        '[PROJECT]'
    );

    create_runtime_project_attachment_sample(
        $formattedParent,
        $runtimeProjectAttachmentId,
        $formattedRuntimeProjectAttachmentRuntimeProject
    );
}
// [END apihub_v1_generated_RuntimeProjectAttachmentService_CreateRuntimeProjectAttachment_sync]
