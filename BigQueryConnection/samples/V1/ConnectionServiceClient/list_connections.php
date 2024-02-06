<?php
/*
 * Copyright 2022 Google LLC
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

// [START bigqueryconnection_v1_generated_ConnectionService_ListConnections_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\BigQuery\Connection\V1\Client\ConnectionServiceClient;
use Google\Cloud\BigQuery\Connection\V1\Connection;
use Google\Cloud\BigQuery\Connection\V1\ListConnectionsRequest;

/**
 * Returns a list of connections in the given project.
 *
 * @param string $formattedParent Parent resource name.
 *                                Must be in the form: `projects/{project_id}/locations/{location_id}`
 *                                Please see {@see ConnectionServiceClient::locationName()} for help formatting this field.
 * @param int    $pageSize        The maximum number of resources contained in the underlying API
 *                                response. The API may return fewer values in a page, even if
 *                                there are additional values to be retrieved.
 */
function list_connections_sample(string $formattedParent, int $pageSize): void
{
    // Create a client.
    $connectionServiceClient = new ConnectionServiceClient();

    // Prepare the request message.
    $request = (new ListConnectionsRequest())
        ->setParent($formattedParent)
        ->setPageSize($pageSize);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $connectionServiceClient->listConnections($request);

        /** @var Connection $element */
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
    $formattedParent = ConnectionServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $pageSize = 0;

    list_connections_sample($formattedParent, $pageSize);
}
// [END bigqueryconnection_v1_generated_ConnectionService_ListConnections_sync]
