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

// [START chat_v1_generated_ChatService_SearchSpaces_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Apps\Chat\V1\Client\ChatServiceClient;
use Google\Apps\Chat\V1\SearchSpacesRequest;
use Google\Apps\Chat\V1\Space;

/**
 * Returns a list of spaces in a Google Workspace organization based on an
 * administrator's search.
 *
 * Requires [user
 * authentication with administrator
 * privileges](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user#admin-privileges).
 * In the request, set `use_admin_access` to `true`.
 *
 * @param string $query A search query.
 *
 *                      You can search by using the following parameters:
 *
 *                      - `create_time`
 *                      - `customer`
 *                      - `display_name`
 *                      - `external_user_allowed`
 *                      - `last_active_time`
 *                      - `space_history_state`
 *                      - `space_type`
 *
 *                      `create_time` and `last_active_time` accept a timestamp in
 *                      [RFC-3339](https://www.rfc-editor.org/rfc/rfc3339) format and the supported
 *                      comparison operators are: `=`, `<`, `>`, `<=`, `>=`.
 *
 *                      `customer` is required and is used to indicate which customer
 *                      to fetch spaces from. `customers/my_customer` is the only supported value.
 *
 *                      `display_name` only accepts the `HAS` (`:`) operator. The text to
 *                      match is first tokenized into tokens and each token is prefix-matched
 *                      case-insensitively and independently as a substring anywhere in the space's
 *                      `display_name`. For example, `Fun Eve` matches `Fun event` or `The
 *                      evening was fun`, but not `notFun event` or `even`.
 *
 *                      `external_user_allowed` accepts either `true` or `false`.
 *
 *                      `space_history_state` only accepts values from the [`historyState`]
 *                      (https://developers.google.com/workspace/chat/api/reference/rest/v1/spaces#Space.HistoryState)
 *                      field of a `space` resource.
 *
 *                      `space_type` is required and the only valid value is `SPACE`.
 *
 *                      Across different fields, only `AND` operators are supported. A valid
 *                      example is `space_type = "SPACE" AND display_name:"Hello"` and an invalid
 *                      example is `space_type = "SPACE" OR display_name:"Hello"`.
 *
 *                      Among the same field,
 *                      `space_type` doesn't support `AND` or `OR` operators.
 *                      `display_name`, 'space_history_state', and 'external_user_allowed' only
 *                      support `OR` operators.
 *                      `last_active_time` and `create_time` support both `AND` and `OR` operators.
 *                      `AND` can only be used to represent an interval, such as `last_active_time
 *                      < "2022-01-01T00:00:00+00:00" AND last_active_time >
 *                      "2023-01-01T00:00:00+00:00"`.
 *
 *                      The following example queries are valid:
 *
 *                      ```
 *                      customer = "customers/my_customer" AND space_type = "SPACE"
 *
 *                      customer = "customers/my_customer" AND space_type = "SPACE" AND
 *                      display_name:"Hello World"
 *
 *                      customer = "customers/my_customer" AND space_type = "SPACE" AND
 *                      (last_active_time < "2020-01-01T00:00:00+00:00" OR last_active_time >
 *                      "2022-01-01T00:00:00+00:00")
 *
 *                      customer = "customers/my_customer" AND space_type = "SPACE" AND
 *                      (display_name:"Hello World" OR display_name:"Fun event") AND
 *                      (last_active_time > "2020-01-01T00:00:00+00:00" AND last_active_time <
 *                      "2022-01-01T00:00:00+00:00")
 *
 *                      customer = "customers/my_customer" AND space_type = "SPACE" AND
 *                      (create_time > "2019-01-01T00:00:00+00:00" AND create_time <
 *                      "2020-01-01T00:00:00+00:00") AND (external_user_allowed = "true") AND
 *                      (space_history_state = "HISTORY_ON" OR space_history_state = "HISTORY_OFF")
 *                      ```
 */
function search_spaces_sample(string $query): void
{
    // Create a client.
    $chatServiceClient = new ChatServiceClient();

    // Prepare the request message.
    $request = (new SearchSpacesRequest())
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $chatServiceClient->searchSpaces($request);

        /** @var Space $element */
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
    $query = '[QUERY]';

    search_spaces_sample($query);
}
// [END chat_v1_generated_ChatService_SearchSpaces_sync]
