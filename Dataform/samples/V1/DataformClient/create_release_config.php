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

// [START dataform_v1_generated_Dataform_CreateReleaseConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1\Client\DataformClient;
use Google\Cloud\Dataform\V1\CreateReleaseConfigRequest;
use Google\Cloud\Dataform\V1\ReleaseConfig;

/**
 * Creates a new ReleaseConfig in a given Repository.
 *
 * @param string $formattedParent           The repository in which to create the release config. Must be in
 *                                          the format `projects/&#42;/locations/&#42;/repositories/*`. Please see
 *                                          {@see DataformClient::repositoryName()} for help formatting this field.
 * @param string $releaseConfigGitCommitish Git commit/tag/branch name at which the repository should be
 *                                          compiled. Must exist in the remote repository. Examples:
 *                                          - a commit SHA: `12ade345`
 *                                          - a tag: `tag1`
 *                                          - a branch name: `branch1`
 * @param string $releaseConfigId           The ID to use for the release config, which will become the final
 *                                          component of the release config's resource name.
 */
function create_release_config_sample(
    string $formattedParent,
    string $releaseConfigGitCommitish,
    string $releaseConfigId
): void {
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $releaseConfig = (new ReleaseConfig())
        ->setGitCommitish($releaseConfigGitCommitish);
    $request = (new CreateReleaseConfigRequest())
        ->setParent($formattedParent)
        ->setReleaseConfig($releaseConfig)
        ->setReleaseConfigId($releaseConfigId);

    // Call the API and handle any network failures.
    try {
        /** @var ReleaseConfig $response */
        $response = $dataformClient->createReleaseConfig($request);
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
    $formattedParent = DataformClient::repositoryName('[PROJECT]', '[LOCATION]', '[REPOSITORY]');
    $releaseConfigGitCommitish = '[GIT_COMMITISH]';
    $releaseConfigId = '[RELEASE_CONFIG_ID]';

    create_release_config_sample($formattedParent, $releaseConfigGitCommitish, $releaseConfigId);
}
// [END dataform_v1_generated_Dataform_CreateReleaseConfig_sync]
