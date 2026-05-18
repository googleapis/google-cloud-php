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

// [START cloudsupport_v2_generated_CommentService_GetComment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\CommentServiceClient;
use Google\Cloud\Support\V2\Comment;
use Google\Cloud\Support\V2\GetCommentRequest;

/**
 * Retrieve a comment.
 *
 * EXAMPLES:
 *
 * cURL:
 *
 * ```shell
 * comment="projects/some-project/cases/43595344/comments/234567890"
 * curl \
 * --header "Authorization: Bearer $(gcloud auth print-access-token)" \
 * "https://cloudsupport.googleapis.com/v2/$comment"
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
 *
 * request = supportApiService.cases().comments().get(
 * name="projects/some-project/cases/43595344/comments/234567890",
 * )
 * print(request.execute())
 * ```
 *
 * @param string $formattedName The name of the comment to retrieve. Please see
 *                              {@see CommentServiceClient::commentName()} for help formatting this field.
 */
function get_comment_sample(string $formattedName): void
{
    // Create a client.
    $commentServiceClient = new CommentServiceClient();

    // Prepare the request message.
    $request = (new GetCommentRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Comment $response */
        $response = $commentServiceClient->getComment($request);
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
    $formattedName = CommentServiceClient::commentName('[ORGANIZATION]', '[CASE]', '[COMMENT]');

    get_comment_sample($formattedName);
}
// [END cloudsupport_v2_generated_CommentService_GetComment_sync]
