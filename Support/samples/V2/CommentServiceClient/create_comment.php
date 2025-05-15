<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudsupport_v2_generated_CommentService_CreateComment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\CommentServiceClient;
use Google\Cloud\Support\V2\Comment;
use Google\Cloud\Support\V2\CreateCommentRequest;

/**
 * Add a new comment to a case.
 *
 * The comment must have the following fields set: `body`.
 *
 * EXAMPLES:
 *
 * cURL:
 *
 * ```shell
 * case="projects/some-project/cases/43591344"
 * curl \
 * --request POST \
 * --header "Authorization: Bearer $(gcloud auth print-access-token)" \
 * --header 'Content-Type: application/json' \
 * --data '{
 * "body": "This is a test comment."
 * }' \
 * "https://cloudsupport.googleapis.com/v2/$case/comments"
 * ```
 *
 * Python:
 *
 * ```python
 * import googleapiclient.discovery
 *
 * api_version = "v2"
 * supportApiService = googleapiclient.discovery.build(
 * serviceName="cloudsupport",
 * version=api_version,
 * discoveryServiceUrl=f"https://cloudsupport.googleapis.com/$discovery/rest?version={api_version}",
 * )
 * request = (
 * supportApiService.cases()
 * .comments()
 * .create(
 * parent="projects/some-project/cases/43595344",
 * body={"body": "This is a test comment."},
 * )
 * )
 * print(request.execute())
 * ```
 *
 * @param string $formattedParent The name of the case to which the comment should be added. Please see
 *                                {@see CommentServiceClient::caseName()} for help formatting this field.
 */
function create_comment_sample(string $formattedParent): void
{
    // Create a client.
    $commentServiceClient = new CommentServiceClient();

    // Prepare the request message.
    $comment = new Comment();
    $request = (new CreateCommentRequest())
        ->setParent($formattedParent)
        ->setComment($comment);

    // Call the API and handle any network failures.
    try {
        /** @var Comment $response */
        $response = $commentServiceClient->createComment($request);
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
    $formattedParent = CommentServiceClient::caseName('[ORGANIZATION]', '[CASE]');

    create_comment_sample($formattedParent);
}
// [END cloudsupport_v2_generated_CommentService_CreateComment_sync]
