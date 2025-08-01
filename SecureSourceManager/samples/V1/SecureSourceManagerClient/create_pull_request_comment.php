<?php
/*
 * Copyright 2025 Google LLC
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

// [START securesourcemanager_v1_generated_SecureSourceManager_CreatePullRequestComment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecureSourceManager\V1\Client\SecureSourceManagerClient;
use Google\Cloud\SecureSourceManager\V1\CreatePullRequestCommentRequest;
use Google\Cloud\SecureSourceManager\V1\PullRequestComment;
use Google\Rpc\Status;

/**
 * Creates a pull request comment. This function is used to create a single
 * PullRequestComment of type Comment, or a single PullRequestComment of type
 * Code that's replying to another PullRequestComment of type Code. Use
 * BatchCreatePullRequestComments to create multiple PullRequestComments for
 * code reviews.
 *
 * @param string $formattedParent The pull request in which to create the pull request comment.
 *                                Format:
 *                                `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/pullRequests/{pull_request_id}`
 *                                Please see {@see SecureSourceManagerClient::pullRequestName()} for help formatting this field.
 */
function create_pull_request_comment_sample(string $formattedParent): void
{
    // Create a client.
    $secureSourceManagerClient = new SecureSourceManagerClient();

    // Prepare the request message.
    $pullRequestComment = new PullRequestComment();
    $request = (new CreatePullRequestCommentRequest())
        ->setParent($formattedParent)
        ->setPullRequestComment($pullRequestComment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $secureSourceManagerClient->createPullRequestComment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PullRequestComment $result */
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
    $formattedParent = SecureSourceManagerClient::pullRequestName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[PULL_REQUEST]'
    );

    create_pull_request_comment_sample($formattedParent);
}
// [END securesourcemanager_v1_generated_SecureSourceManager_CreatePullRequestComment_sync]
