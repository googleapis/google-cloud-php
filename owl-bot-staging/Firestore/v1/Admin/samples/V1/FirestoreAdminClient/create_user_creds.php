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

// [START firestore_v1_generated_FirestoreAdmin_CreateUserCreds_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\Admin\V1\Client\FirestoreAdminClient;
use Google\Cloud\Firestore\Admin\V1\CreateUserCredsRequest;
use Google\Cloud\Firestore\Admin\V1\UserCreds;

/**
 * Create a user creds.
 *
 * @param string $formattedParent A parent name of the form
 *                                `projects/{project_id}/databases/{database_id}`
 *                                Please see {@see FirestoreAdminClient::databaseName()} for help formatting this field.
 * @param string $userCredsId     The ID to use for the user creds, which will become the final
 *                                component of the user creds's resource name.
 *
 *                                This value should be 4-63 characters. Valid characters are /[a-z][0-9]-/
 *                                with first character a letter and the last a letter or a number. Must not
 *                                be UUID-like /[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}/.
 */
function create_user_creds_sample(string $formattedParent, string $userCredsId): void
{
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Prepare the request message.
    $userCreds = new UserCreds();
    $request = (new CreateUserCredsRequest())
        ->setParent($formattedParent)
        ->setUserCreds($userCreds)
        ->setUserCredsId($userCredsId);

    // Call the API and handle any network failures.
    try {
        /** @var UserCreds $response */
        $response = $firestoreAdminClient->createUserCreds($request);
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
    $userCredsId = '[USER_CREDS_ID]';

    create_user_creds_sample($formattedParent, $userCredsId);
}
// [END firestore_v1_generated_FirestoreAdmin_CreateUserCreds_sync]
