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

// [START developerconnect_v1_generated_DeveloperConnect_FetchGitRefs_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DeveloperConnect\V1\Client\DeveloperConnectClient;
use Google\Cloud\DeveloperConnect\V1\FetchGitRefsRequest;
use Google\Cloud\DeveloperConnect\V1\FetchGitRefsRequest\RefType;

/**
 * Fetch the list of branches or tags for a given repository.
 *
 * @param string $formattedGitRepositoryLink The resource name of GitRepositoryLink in the format
 *                                           `projects/&#42;/locations/&#42;/connections/&#42;/gitRepositoryLinks/*`. Please see
 *                                           {@see DeveloperConnectClient::gitRepositoryLinkName()} for help formatting this field.
 * @param int    $refType                    Type of refs to fetch.
 */
function fetch_git_refs_sample(string $formattedGitRepositoryLink, int $refType): void
{
    // Create a client.
    $developerConnectClient = new DeveloperConnectClient();

    // Prepare the request message.
    $request = (new FetchGitRefsRequest())
        ->setGitRepositoryLink($formattedGitRepositoryLink)
        ->setRefType($refType);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $developerConnectClient->fetchGitRefs($request);

        /** @var string $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element);
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
    $formattedGitRepositoryLink = DeveloperConnectClient::gitRepositoryLinkName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION]',
        '[GIT_REPOSITORY_LINK]'
    );
    $refType = RefType::REF_TYPE_UNSPECIFIED;

    fetch_git_refs_sample($formattedGitRepositoryLink, $refType);
}
// [END developerconnect_v1_generated_DeveloperConnect_FetchGitRefs_sync]
