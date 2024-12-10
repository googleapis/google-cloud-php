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

// [START clouderrorreporting_v1beta1_generated_ErrorStatsService_ListGroupStats_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ErrorReporting\V1beta1\Client\ErrorStatsServiceClient;
use Google\Cloud\ErrorReporting\V1beta1\ErrorGroupStats;
use Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsRequest;

/**
 * Lists the specified groups.
 *
 * @param string $formattedProjectName The resource name of the Google Cloud Platform project. Written
 *                                     as `projects/{projectID}` or `projects/{projectNumber}`, where
 *                                     `{projectID}` and `{projectNumber}` can be found in the
 *                                     [Google Cloud console](https://support.google.com/cloud/answer/6158840).
 *                                     It may also include a location, such as
 *                                     `projects/{projectID}/locations/{location}` where `{location}` is a cloud
 *                                     region.
 *
 *                                     Examples: `projects/my-project-123`, `projects/5551234`,
 *                                     `projects/my-project-123/locations/us-central1`,
 *                                     `projects/5551234/locations/us-central1`.
 *
 *                                     For a list of supported locations, see [Supported
 *                                     Regions](https://cloud.google.com/logging/docs/region-support). `global` is
 *                                     the default when unspecified. Use `-` as a wildcard to request group stats
 *                                     from all regions. Please see
 *                                     {@see ErrorStatsServiceClient::projectName()} for help formatting this field.
 */
function list_group_stats_sample(string $formattedProjectName): void
{
    // Create a client.
    $errorStatsServiceClient = new ErrorStatsServiceClient();

    // Prepare the request message.
    $request = (new ListGroupStatsRequest())
        ->setProjectName($formattedProjectName);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $errorStatsServiceClient->listGroupStats($request);

        /** @var ErrorGroupStats $element */
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
    $formattedProjectName = ErrorStatsServiceClient::projectName('[PROJECT]');

    list_group_stats_sample($formattedProjectName);
}
// [END clouderrorreporting_v1beta1_generated_ErrorStatsService_ListGroupStats_sync]
