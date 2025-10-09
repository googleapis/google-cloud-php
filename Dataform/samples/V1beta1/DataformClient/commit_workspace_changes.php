<?php
/*
 * Copyright 2022 Google LLC
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

// [START dataform_v1beta1_generated_Dataform_CommitWorkspaceChanges_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;
use Google\Cloud\Dataform\V1beta1\CommitAuthor;
use Google\Cloud\Dataform\V1beta1\CommitWorkspaceChangesRequest;
use Google\Cloud\Dataform\V1beta1\CommitWorkspaceChangesResponse;

/**
 * Applies a Git commit for uncommitted files in a Workspace.
 *
 * @param string $formattedName      The workspace's name. Please see
 *                                   {@see DataformClient::workspaceName()} for help formatting this field.
 * @param string $authorName         The commit author's name.
 * @param string $authorEmailAddress The commit author's email address.
 */
function commit_workspace_changes_sample(
    string $formattedName,
    string $authorName,
    string $authorEmailAddress
): void {
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $author = (new CommitAuthor())
        ->setName($authorName)
        ->setEmailAddress($authorEmailAddress);
    $request = (new CommitWorkspaceChangesRequest())
        ->setName($formattedName)
        ->setAuthor($author);

    // Call the API and handle any network failures.
    try {
        /** @var CommitWorkspaceChangesResponse $response */
        $response = $dataformClient->commitWorkspaceChanges($request);
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
    $formattedName = DataformClient::workspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[WORKSPACE]'
    );
    $authorName = '[NAME]';
    $authorEmailAddress = '[EMAIL_ADDRESS]';

    commit_workspace_changes_sample($formattedName, $authorName, $authorEmailAddress);
}
// [END dataform_v1beta1_generated_Dataform_CommitWorkspaceChanges_sync]
