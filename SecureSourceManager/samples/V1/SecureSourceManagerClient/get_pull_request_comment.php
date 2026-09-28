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

// [START securesourcemanager_v1_generated_SecureSourceManager_GetPullRequestComment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecureSourceManager\V1\Client\SecureSourceManagerClient;
use Google\Cloud\SecureSourceManager\V1\GetPullRequestCommentRequest;
use Google\Cloud\SecureSourceManager\V1\PullRequestComment;

/**
 * Gets a pull request comment.
 *
 * @param string $formattedName Name of the pull request comment to retrieve.
 *                              The format is
 *                              `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/pullRequests/{pull_request_id}/pullRequestComments/{comment_id}`. Please see
 *                              {@see SecureSourceManagerClient::pullRequestCommentName()} for help formatting this field.
 */
function get_pull_request_comment_sample(string $formattedName): void
{
    // Create a client.
    $secureSourceManagerClient = new SecureSourceManagerClient();

    // Prepare the request message.
    $request = (new GetPullRequestCommentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PullRequestComment $response */
        $response = $secureSourceManagerClient->getPullRequestComment($request);
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
    $formattedName = SecureSourceManagerClient::pullRequestCommentName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[PULL_REQUEST]',
        '[COMMENT]'
    );

    get_pull_request_comment_sample($formattedName);
}
// [END securesourcemanager_v1_generated_SecureSourceManager_GetPullRequestComment_sync]
