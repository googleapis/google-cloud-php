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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_GetComment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\Comment;
use Google\Cloud\GdcHardwareManagement\V1alpha\GetCommentRequest;

/**
 * Gets the content of a comment.
 *
 * @param string $formattedName The name of the comment.
 *                              Format:
 *                              `projects/{project}/locations/{location}/orders/{order}/comments/{comment}`
 *                              Please see {@see GDCHardwareManagementClient::commentName()} for help formatting this field.
 */
function get_comment_sample(string $formattedName): void
{
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $request = (new GetCommentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Comment $response */
        $response = $gDCHardwareManagementClient->getComment($request);
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
    $formattedName = GDCHardwareManagementClient::commentName(
        '[PROJECT]',
        '[LOCATION]',
        '[ORDER]',
        '[COMMENT]'
    );

    get_comment_sample($formattedName);
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_GetComment_sync]
