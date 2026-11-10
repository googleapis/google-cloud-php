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

// [START chronicle_v1_generated_SearchService_Search_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Chronicle\V1\Client\SearchServiceClient;
use Google\Cloud\Chronicle\V1\SearchRequest;
use Google\Cloud\Chronicle\V1\SearchSession;
use Google\Rpc\Status;
use Google\Type\Interval;

/**
 * Initiates a long-running search operation.
 *
 * @param string $formattedParent The resource name of the instance on which to perform the search.
 *                                Format: projects/{project}/locations/{location}/instances/{instance}
 *                                Please see {@see SearchServiceClient::instanceName()} for help formatting this field.
 * @param string $query           The search query, in the dialect set in `dialect`.
 *                                Example: 'ip=/172.&#42;/ AND metadata.event_type!="NETWORK_CONNECTION" AND (
 *                                target.ip = "3.225.179.73" OR target.ip = "23.47.48.70")'
 */
function search_sample(string $formattedParent, string $query): void
{
    // Create a client.
    $searchServiceClient = new SearchServiceClient();

    // Prepare the request message.
    $timeRange = new Interval();
    $request = (new SearchRequest())
        ->setParent($formattedParent)
        ->setQuery($query)
        ->setTimeRange($timeRange);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $searchServiceClient->search($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SearchSession $result */
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
    $formattedParent = SearchServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $query = '[QUERY]';

    search_sample($formattedParent, $query);
}
// [END chronicle_v1_generated_SearchService_Search_sync]
