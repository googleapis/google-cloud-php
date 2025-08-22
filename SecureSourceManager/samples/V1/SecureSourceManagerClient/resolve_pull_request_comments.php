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

// [START securesourcemanager_v1_generated_SecureSourceManager_ResolvePullRequestComments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecureSourceManager\V1\Client\SecureSourceManagerClient;
use Google\Cloud\SecureSourceManager\V1\ResolvePullRequestCommentsRequest;
use Google\Cloud\SecureSourceManager\V1\ResolvePullRequestCommentsResponse;
use Google\Rpc\Status;

/**
 * Resolves pull request comments. A list of PullRequestComment names must be
 * provided. The PullRequestComment names must be in the same conversation
 * thread. If auto_fill is set, all comments in the conversation thread will
 * be resolved.
 *
 * @param string $formattedParent       The pull request in which to resolve the pull request comments.
 *                                      Format:
 *                                      `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/pullRequests/{pull_request_id}`
 *                                      Please see {@see SecureSourceManagerClient::pullRequestName()} for help formatting this field.
 * @param string $formattedNamesElement The names of the pull request comments to resolve. Format:
 *                                      `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/pullRequests/{pull_request_id}/pullRequestComments/{comment_id}`
 *                                      Only comments from the same threads are allowed in the same request. Please see
 *                                      {@see SecureSourceManagerClient::pullRequestCommentName()} for help formatting this field.
 */
function resolve_pull_request_comments_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $secureSourceManagerClient = new SecureSourceManagerClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new ResolvePullRequestCommentsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $secureSourceManagerClient->resolvePullRequestComments($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ResolvePullRequestCommentsResponse $result */
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
    $formattedNamesElement = SecureSourceManagerClient::pullRequestCommentName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[PULL_REQUEST]',
        '[COMMENT]'
    );

    resolve_pull_request_comments_sample($formattedParent, $formattedNamesElement);
}
// [END securesourcemanager_v1_generated_SecureSourceManager_ResolvePullRequestComments_sync]
