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

// [START chronicle_v1_generated_DashboardQueryService_ExecuteDashboardQuery_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DashboardQueryServiceClient;
use Google\Cloud\Chronicle\V1\DashboardQuery;
use Google\Cloud\Chronicle\V1\DashboardQuery\Input;
use Google\Cloud\Chronicle\V1\ExecuteDashboardQueryRequest;
use Google\Cloud\Chronicle\V1\ExecuteDashboardQueryResponse;

/**
 * Execute a query and return the data.
 *
 * @param string $formattedParent The parent, under which to run this dashboardQuery.
 *                                Format: projects/{project}/locations/{location}/instances/{instance}
 *                                Please see {@see DashboardQueryServiceClient::instanceName()} for help formatting this field.
 * @param string $queryQuery      Search query string.
 */
function execute_dashboard_query_sample(string $formattedParent, string $queryQuery): void
{
    // Create a client.
    $dashboardQueryServiceClient = new DashboardQueryServiceClient();

    // Prepare the request message.
    $queryInput = new Input();
    $query = (new DashboardQuery())
        ->setQuery($queryQuery)
        ->setInput($queryInput);
    $request = (new ExecuteDashboardQueryRequest())
        ->setParent($formattedParent)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var ExecuteDashboardQueryResponse $response */
        $response = $dashboardQueryServiceClient->executeDashboardQuery($request);
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
    $formattedParent = DashboardQueryServiceClient::instanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]'
    );
    $queryQuery = '[QUERY]';

    execute_dashboard_query_sample($formattedParent, $queryQuery);
}
// [END chronicle_v1_generated_DashboardQueryService_ExecuteDashboardQuery_sync]
