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

// [START developerconnect_v1_generated_DeveloperConnect_CreateGitRepositoryLink_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DeveloperConnect\V1\Client\DeveloperConnectClient;
use Google\Cloud\DeveloperConnect\V1\CreateGitRepositoryLinkRequest;
use Google\Cloud\DeveloperConnect\V1\GitRepositoryLink;
use Google\Rpc\Status;

/**
 * Creates a GitRepositoryLink. Upon linking a Git Repository, Developer
 * Connect will configure the Git Repository to send webhook events to
 * Developer Connect. Connections that use Firebase GitHub Application will
 * have events forwarded to the Firebase service. All other Connections will
 * have events forwarded to Cloud Build.
 *
 * @param string $formattedParent           Value for parent. Please see
 *                                          {@see DeveloperConnectClient::connectionName()} for help formatting this field.
 * @param string $gitRepositoryLinkCloneUri Git Clone URI.
 * @param string $gitRepositoryLinkId       The ID to use for the repository, which will become the final
 *                                          component of the repository's resource name. This ID should be unique in
 *                                          the connection. Allows alphanumeric characters and any of
 *                                          -._~%!$&'()*+,;=&#64;.
 */
function create_git_repository_link_sample(
    string $formattedParent,
    string $gitRepositoryLinkCloneUri,
    string $gitRepositoryLinkId
): void {
    // Create a client.
    $developerConnectClient = new DeveloperConnectClient();

    // Prepare the request message.
    $gitRepositoryLink = (new GitRepositoryLink())
        ->setCloneUri($gitRepositoryLinkCloneUri);
    $request = (new CreateGitRepositoryLinkRequest())
        ->setParent($formattedParent)
        ->setGitRepositoryLink($gitRepositoryLink)
        ->setGitRepositoryLinkId($gitRepositoryLinkId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $developerConnectClient->createGitRepositoryLink($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GitRepositoryLink $result */
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
    $formattedParent = DeveloperConnectClient::connectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION]'
    );
    $gitRepositoryLinkCloneUri = '[CLONE_URI]';
    $gitRepositoryLinkId = '[GIT_REPOSITORY_LINK_ID]';

    create_git_repository_link_sample(
        $formattedParent,
        $gitRepositoryLinkCloneUri,
        $gitRepositoryLinkId
    );
}
// [END developerconnect_v1_generated_DeveloperConnect_CreateGitRepositoryLink_sync]
