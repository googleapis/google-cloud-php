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

// [START apphub_v1_generated_AppHub_DetachServiceProjectAttachment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\DetachServiceProjectAttachmentRequest;
use Google\Cloud\AppHub\V1\DetachServiceProjectAttachmentResponse;

/**
 * Detaches a service project from a host project.
 * You can call this API from any service project without needing access to
 * the host project that it is attached to.
 *
 * @param string $formattedName Service project id and location to detach from a host project.
 *                              Only global location is supported. Expected format:
 *                              `projects/{project}/locations/{location}`. Please see
 *                              {@see AppHubClient::locationName()} for help formatting this field.
 */
function detach_service_project_attachment_sample(string $formattedName): void
{
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $request = (new DetachServiceProjectAttachmentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DetachServiceProjectAttachmentResponse $response */
        $response = $appHubClient->detachServiceProjectAttachment($request);
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
    $formattedName = AppHubClient::locationName('[PROJECT]', '[LOCATION]');

    detach_service_project_attachment_sample($formattedName);
}
// [END apphub_v1_generated_AppHub_DetachServiceProjectAttachment_sync]
