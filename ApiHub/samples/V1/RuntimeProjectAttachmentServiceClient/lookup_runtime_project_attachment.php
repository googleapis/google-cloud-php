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

// [START apihub_v1_generated_RuntimeProjectAttachmentService_LookupRuntimeProjectAttachment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\RuntimeProjectAttachmentServiceClient;
use Google\Cloud\ApiHub\V1\LookupRuntimeProjectAttachmentRequest;
use Google\Cloud\ApiHub\V1\LookupRuntimeProjectAttachmentResponse;

/**
 * Look up a runtime project attachment. This API can be called in the context
 * of any project.
 *
 * @param string $formattedName Runtime project ID to look up runtime project attachment for.
 *                              Lookup happens across all regions. Expected format:
 *                              `projects/{project}/locations/{location}`. Please see
 *                              {@see RuntimeProjectAttachmentServiceClient::locationName()} for help formatting this field.
 */
function lookup_runtime_project_attachment_sample(string $formattedName): void
{
    // Create a client.
    $runtimeProjectAttachmentServiceClient = new RuntimeProjectAttachmentServiceClient();

    // Prepare the request message.
    $request = (new LookupRuntimeProjectAttachmentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var LookupRuntimeProjectAttachmentResponse $response */
        $response = $runtimeProjectAttachmentServiceClient->lookupRuntimeProjectAttachment($request);
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
    $formattedName = RuntimeProjectAttachmentServiceClient::locationName('[PROJECT]', '[LOCATION]');

    lookup_runtime_project_attachment_sample($formattedName);
}
// [END apihub_v1_generated_RuntimeProjectAttachmentService_LookupRuntimeProjectAttachment_sync]
