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

// [START clouderrorreporting_v1beta1_generated_ErrorGroupService_GetGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ErrorReporting\V1beta1\Client\ErrorGroupServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ErrorGroup;
use Google\Cloud\ErrorReporting\V1beta1\GetGroupRequest;

/**
 * Get the specified group.
 *
 * @param string $formattedGroupName The group resource name. Written as either
 *                                   `projects/{projectID}/groups/{group_id}` or
 *                                   `projects/{projectID}/locations/{location}/groups/{group_id}`. Call
 *                                   [groupStats.list]
 *                                   [google.devtools.clouderrorreporting.v1beta1.ErrorStatsService.ListGroupStats]
 *                                   to return a list of groups belonging to this project.
 *
 *                                   Examples: `projects/my-project-123/groups/my-group`,
 *                                   `projects/my-project-123/locations/global/groups/my-group`
 *
 *                                   In the group resource name, the `group_id` is a unique identifier for a
 *                                   particular error group. The identifier is derived from key parts of the
 *                                   error-log content and is treated as Service Data. For information about
 *                                   how Service Data is handled, see [Google Cloud Privacy
 *                                   Notice](https://cloud.google.com/terms/cloud-privacy-notice).
 *
 *                                   For a list of supported locations, see [Supported
 *                                   Regions](https://cloud.google.com/logging/docs/region-support). `global` is
 *                                   the default when unspecified. Please see
 *                                   {@see ErrorGroupServiceClient::errorGroupName()} for help formatting this field.
 */
function get_group_sample(string $formattedGroupName): void
{
    // Create a client.
    $errorGroupServiceClient = new ErrorGroupServiceClient();

    // Prepare the request message.
    $request = (new GetGroupRequest())
        ->setGroupName($formattedGroupName);

    // Call the API and handle any network failures.
    try {
        /** @var ErrorGroup $response */
        $response = $errorGroupServiceClient->getGroup($request);
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
    $formattedGroupName = ErrorGroupServiceClient::errorGroupName('[PROJECT]', '[GROUP]');

    get_group_sample($formattedGroupName);
}
// [END clouderrorreporting_v1beta1_generated_ErrorGroupService_GetGroup_sync]
