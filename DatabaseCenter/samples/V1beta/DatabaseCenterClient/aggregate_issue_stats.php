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

// [START databasecenter_v1beta_generated_DatabaseCenter_AggregateIssueStats_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DatabaseCenter\V1beta\AggregateIssueStatsRequest;
use Google\Cloud\DatabaseCenter\V1beta\AggregateIssueStatsResponse;
use Google\Cloud\DatabaseCenter\V1beta\Client\DatabaseCenterClient;

/**
 * AggregateIssueStats provides database resource issues statistics.
 *
 * @param string $parent Parent can be a project, a folder, or an organization. The search
 *                       is limited to the resources within the `scope`.
 *
 *                       The allowed values are:
 *
 *                       * projects/{PROJECT_ID} (e.g., "projects/foo-bar")
 *                       * projects/{PROJECT_NUMBER} (e.g., "projects/12345678")
 *                       * folders/{FOLDER_NUMBER} (e.g., "folders/1234567")
 *                       * organizations/{ORGANIZATION_NUMBER} (e.g., "organizations/123456")
 */
function aggregate_issue_stats_sample(string $parent): void
{
    // Create a client.
    $databaseCenterClient = new DatabaseCenterClient();

    // Prepare the request message.
    $request = (new AggregateIssueStatsRequest())
        ->setParent($parent);

    // Call the API and handle any network failures.
    try {
        /** @var AggregateIssueStatsResponse $response */
        $response = $databaseCenterClient->aggregateIssueStats($request);
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
    $parent = '[PARENT]';

    aggregate_issue_stats_sample($parent);
}
// [END databasecenter_v1beta_generated_DatabaseCenter_AggregateIssueStats_sync]
