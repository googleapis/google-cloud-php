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

// [START datalineage_v1_generated_Lineage_ListRuns_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DataCatalog\Lineage\V1\Client\LineageClient;
use Google\Cloud\DataCatalog\Lineage\V1\ListRunsRequest;
use Google\Cloud\DataCatalog\Lineage\V1\Run;

/**
 * Lists runs in the given project and location. List order is descending by
 * `start_time`.
 *
 * @param string $formattedParent The name of process that owns this collection of runs. Please see
 *                                {@see LineageClient::processName()} for help formatting this field.
 */
function list_runs_sample(string $formattedParent): void
{
    // Create a client.
    $lineageClient = new LineageClient();

    // Prepare the request message.
    $request = (new ListRunsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $lineageClient->listRuns($request);

        /** @var Run $element */
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
    $formattedParent = LineageClient::processName('[PROJECT]', '[LOCATION]', '[PROCESS]');

    list_runs_sample($formattedParent);
}
// [END datalineage_v1_generated_Lineage_ListRuns_sync]
