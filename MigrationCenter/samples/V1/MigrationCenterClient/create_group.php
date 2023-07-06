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

// [START migrationcenter_v1_generated_MigrationCenter_CreateGroup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\MigrationCenter\V1\Client\MigrationCenterClient;
use Google\Cloud\MigrationCenter\V1\CreateGroupRequest;
use Google\Cloud\MigrationCenter\V1\Group;
use Google\Rpc\Status;

/**
 * Creates a new group in a given project and location.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see MigrationCenterClient::locationName()} for help formatting this field.
 * @param string $groupId         User specified ID for the group. It will become the last
 *                                component of the group name. The ID must be unique within the project, must
 *                                conform with RFC-1034, is restricted to lower-cased letters, and has a
 *                                maximum length of 63 characters. The ID must match the regular expression:
 *                                `[a-z]([a-z0-9-]{0,61}[a-z0-9])?`.
 */
function create_group_sample(string $formattedParent, string $groupId): void
{
    // Create a client.
    $migrationCenterClient = new MigrationCenterClient();

    // Prepare the request message.
    $group = new Group();
    $request = (new CreateGroupRequest())
        ->setParent($formattedParent)
        ->setGroupId($groupId)
        ->setGroup($group);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $migrationCenterClient->createGroup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Group $result */
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
    $formattedParent = MigrationCenterClient::locationName('[PROJECT]', '[LOCATION]');
    $groupId = '[GROUP_ID]';

    create_group_sample($formattedParent, $groupId);
}
// [END migrationcenter_v1_generated_MigrationCenter_CreateGroup_sync]
