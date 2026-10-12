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

// [START meet_v2_generated_SpacesService_BatchUpdateMembers_sync]
use Google\ApiCore\ApiException;
use Google\Apps\Meet\V2\BatchUpdateMembersRequest;
use Google\Apps\Meet\V2\BatchUpdateMembersResponse;
use Google\Apps\Meet\V2\Client\SpacesServiceClient;
use Google\Apps\Meet\V2\Member;
use Google\Apps\Meet\V2\UpdateMemberRequest;

/**
 * Updates members of one space within a batch.
 *
 * @param string $formattedParent The parent resource shared by all Members being updated.
 *                                Format: spaces/{space}
 *                                Please see {@see SpacesServiceClient::spaceName()} for help formatting this field.
 */
function batch_update_members_sample(string $formattedParent): void
{
    // Create a client.
    $spacesServiceClient = new SpacesServiceClient();

    // Prepare the request message.
    $requestsMember = new Member();
    $updateMemberRequest = (new UpdateMemberRequest())
        ->setMember($requestsMember);
    $requests = [$updateMemberRequest,];
    $request = (new BatchUpdateMembersRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateMembersResponse $response */
        $response = $spacesServiceClient->batchUpdateMembers($request);
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
    $formattedParent = SpacesServiceClient::spaceName('[SPACE]');

    batch_update_members_sample($formattedParent);
}
// [END meet_v2_generated_SpacesService_BatchUpdateMembers_sync]
