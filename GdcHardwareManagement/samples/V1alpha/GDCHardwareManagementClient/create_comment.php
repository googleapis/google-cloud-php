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

// [START gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateComment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GdcHardwareManagement\V1alpha\Client\GDCHardwareManagementClient;
use Google\Cloud\GdcHardwareManagement\V1alpha\Comment;
use Google\Cloud\GdcHardwareManagement\V1alpha\CreateCommentRequest;
use Google\Rpc\Status;

/**
 * Creates a new comment on an order.
 *
 * @param string $formattedParent The order to create the comment on.
 *                                Format: `projects/{project}/locations/{location}/orders/{order}`
 *                                Please see {@see GDCHardwareManagementClient::orderName()} for help formatting this field.
 * @param string $commentText     Text of this comment. The length of text must be <= 1000
 *                                characters.
 */
function create_comment_sample(string $formattedParent, string $commentText): void
{
    // Create a client.
    $gDCHardwareManagementClient = new GDCHardwareManagementClient();

    // Prepare the request message.
    $comment = (new Comment())
        ->setText($commentText);
    $request = (new CreateCommentRequest())
        ->setParent($formattedParent)
        ->setComment($comment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $gDCHardwareManagementClient->createComment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Comment $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedParent = GDCHardwareManagementClient::orderName('[PROJECT]', '[LOCATION]', '[ORDER]');
    $commentText = '[TEXT]';

    create_comment_sample($formattedParent, $commentText);
}
// [END gdchardwaremanagement_v1alpha_generated_GDCHardwareManagement_CreateComment_sync]
