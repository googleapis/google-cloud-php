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

// [START dataform_v1beta1_generated_Dataform_CommitRepositoryChanges_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\Cloud\Dataform\V1beta1\CommitAuthor;
use Google\Cloud\Dataform\V1beta1\CommitMetadata;
use Google\Cloud\Dataform\V1beta1\CommitRepositoryChangesRequest;
use Google\Cloud\Dataform\V1beta1\CommitRepositoryChangesResponse;

/**
 * Applies a Git commit to a Repository. The Repository must not have a value
 * for `git_remote_settings.url`.
 *
 * @param string $formattedName                    The repository's name. Please see
 *                                                 {@see DataformClient::repositoryName()} for help formatting this field.
 * @param string $commitMetadataAuthorName         The commit author's name.
 * @param string $commitMetadataAuthorEmailAddress The commit author's email address.
 */
function commit_repository_changes_sample(
    string $formattedName,
    string $commitMetadataAuthorName,
    string $commitMetadataAuthorEmailAddress
): void {
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $commitMetadataAuthor = (new CommitAuthor())
        ->setName($commitMetadataAuthorName)
        ->setEmailAddress($commitMetadataAuthorEmailAddress);
    $commitMetadata = (new CommitMetadata())
        ->setAuthor($commitMetadataAuthor);
    $request = (new CommitRepositoryChangesRequest())
        ->setName($formattedName)
        ->setCommitMetadata($commitMetadata);

    // Call the API and handle any network failures.
    try {
        /** @var CommitRepositoryChangesResponse $response */
        $response = $dataformClient->commitRepositoryChanges($request);
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
    $formattedName = DataformClient::repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
    $commitMetadataAuthorName = '[NAME]';
    $commitMetadataAuthorEmailAddress = '[EMAIL_ADDRESS]';

    commit_repository_changes_sample(
        $formattedName,
        $commitMetadataAuthorName,
        $commitMetadataAuthorEmailAddress
    );
}
// [END dataform_v1beta1_generated_Dataform_CommitRepositoryChanges_sync]
