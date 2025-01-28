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

// [START meet_v2beta_generated_SpacesService_ListMembers_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Meet\V2beta\Client\SpacesServiceClient;
use Google\Apps\Meet\V2beta\ListMembersRequest;
use Google\Apps\Meet\V2beta\Member;

/**
 * [Developer Preview](https://developers.google.com/workspace/preview):
 * List members.
 *
 * This API supports the `fields` parameter in
 * [SystemParameterContext](https://cloud.google.com/apis/docs/system-parameters).
 * When the `fields` parameter is omitted this API response will default to
 * "name,email,role,user".
 *
 * @param string $formattedParent Format: spaces/{space}
 *                                Please see {@see SpacesServiceClient::spaceName()} for help formatting this field.
 */
function list_members_sample(string $formattedParent): void
{
    // Create a client.
    $spacesServiceClient = new SpacesServiceClient();

    // Prepare the request message.
    $request = (new ListMembersRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $spacesServiceClient->listMembers($request);

        /** @var Member $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = SpacesServiceClient::spaceName('[SPACE]');

    list_members_sample($formattedParent);
}
// [END meet_v2beta_generated_SpacesService_ListMembers_sync]
