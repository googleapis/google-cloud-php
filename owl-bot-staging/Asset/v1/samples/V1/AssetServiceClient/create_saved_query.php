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

// [START cloudasset_v1_generated_AssetService_CreateSavedQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\SavedQuery;

/**
 * Creates a saved query in a parent project/folder/organization.
 *
 * @param string $formattedParent The name of the project/folder/organization where this
 *                                saved_query should be created in. It can only be an organization number
 *                                (such as "organizations/123"), a folder number (such as "folders/123"), a
 *                                project ID (such as "projects/my-project-id"), or a project number (such as
 *                                "projects/12345"). Please see
 *                                {@see AssetServiceClient::projectName()} for help formatting this field.
 * @param string $savedQueryId    The ID to use for the saved query, which must be unique in the
 *                                specified parent. It will become the final component of the saved query's
 *                                resource name.
 *
 *                                This value should be 4-63 characters, and valid characters
 *                                are `[a-z][0-9]-`.
 *
 *                                Notice that this field is required in the saved query creation, and the
 *                                `name` field of the `saved_query` will be ignored.
 */
function create_saved_query_sample(string $formattedParent, string $savedQueryId): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $savedQuery = new SavedQuery();

    // Call the API and handle any network failures.
    try {
        /** @var SavedQuery $response */
        $response = $assetServiceClient->createSavedQuery($formattedParent, $savedQuery, $savedQueryId);
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
    $formattedParent = AssetServiceClient::projectName('[PROJECT]');
    $savedQueryId = '[SAVED_QUERY_ID]';

    create_saved_query_sample($formattedParent, $savedQueryId);
}
// [END cloudasset_v1_generated_AssetService_CreateSavedQuery_sync]
