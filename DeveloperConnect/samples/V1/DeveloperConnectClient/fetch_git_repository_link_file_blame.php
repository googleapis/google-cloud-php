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

// [START developerconnect_v1_generated_DeveloperConnect_FetchGitRepositoryLinkFileBlame_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DeveloperConnect\V1\Client\DeveloperConnectClient;
use Google\Cloud\DeveloperConnect\V1\FetchGitRepositoryLinkFileBlameRequest;
use Google\Cloud\DeveloperConnect\V1\FetchGitRepositoryLinkFileBlameResponse;

/**
 * Fetches blame information for a file or line range in a file.
 *
 * @param string $formattedName The resource name of the GitRepositoryLink in the format
 *                              `projects/&#42;/locations/&#42;/connections/&#42;/gitRepositoryLinks/*`. Please see
 *                              {@see DeveloperConnectClient::gitRepositoryLinkName()} for help formatting this field.
 * @param string $ref           The SCM commit SHA, or symbolic revision (e.g., branch name, tag)
 *                              from which to fetch the blame.
 * @param string $path          The file path within the repository.
 */
function fetch_git_repository_link_file_blame_sample(
    string $formattedName,
    string $ref,
    string $path
): void {
    // Create a client.
    $developerConnectClient = new DeveloperConnectClient();

    // Prepare the request message.
    $request = (new FetchGitRepositoryLinkFileBlameRequest())
        ->setName($formattedName)
        ->setRef($ref)
        ->setPath($path);

    // Call the API and handle any network failures.
    try {
        /** @var FetchGitRepositoryLinkFileBlameResponse $response */
        $response = $developerConnectClient->fetchGitRepositoryLinkFileBlame($request);
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
    $formattedName = DeveloperConnectClient::gitRepositoryLinkName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION]',
        '[GIT_REPOSITORY_LINK]'
    );
    $ref = '[REF]';
    $path = '[PATH]';

    fetch_git_repository_link_file_blame_sample($formattedName, $ref, $path);
}
// [END developerconnect_v1_generated_DeveloperConnect_FetchGitRepositoryLinkFileBlame_sync]
