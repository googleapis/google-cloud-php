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

// [START firestore_v1_generated_FirestoreAdmin_ListUserCreds_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\Admin\V1\Client\FirestoreAdminClient;
use Google\Cloud\Firestore\Admin\V1\ListUserCredsRequest;
use Google\Cloud\Firestore\Admin\V1\ListUserCredsResponse;

/**
 * List all user creds in the database. Note that the returned resource
 * does not contain the secret value itself.
 *
 * @param string $formattedParent A parent database name of the form
 *                                `projects/{project_id}/databases/{database_id}`
 *                                Please see {@see FirestoreAdminClient::databaseName()} for help formatting this field.
 */
function list_user_creds_sample(string $formattedParent): void
{
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Prepare the request message.
    $request = (new ListUserCredsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var ListUserCredsResponse $response */
        $response = $firestoreAdminClient->listUserCreds($request);
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
    $formattedParent = FirestoreAdminClient::databaseName('[PROJECT]', '[DATABASE]');

    list_user_creds_sample($formattedParent);
}
// [END firestore_v1_generated_FirestoreAdmin_ListUserCreds_sync]
