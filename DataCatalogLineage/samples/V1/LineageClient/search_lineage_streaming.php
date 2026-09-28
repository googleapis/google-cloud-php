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

// [START datalineage_v1_generated_Lineage_SearchLineageStreaming_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\DataCatalog\Lineage\V1\Client\LineageClient;
use Google\Cloud\DataCatalog\Lineage\V1\SearchLineageStreamingRequest;
use Google\Cloud\DataCatalog\Lineage\V1\SearchLineageStreamingRequest\RootCriteria;
use Google\Cloud\DataCatalog\Lineage\V1\SearchLineageStreamingRequest\SearchDirection;
use Google\Cloud\DataCatalog\Lineage\V1\SearchLineageStreamingResponse;

/**
 * Retrieves a streaming response of lineage links connected to the requested
 * assets by performing a breadth-first search in the given direction. Links
 * represent the data flow between **source** (upstream) and **target**
 * (downstream) assets in transformation pipelines. Links are stored in the
 * same project as the Lineage Events that create them. This method retrieves
 * links from all valid locations provided in the request. This method
 * supports Column-Level Lineage (CLL) along with wildcard support to retrieve
 * all CLL for an Entity FQN.
 *
 * Following permissions are required to retrieve links:
 * * `datalineage.events.get` permission for the project where the link is
 * stored for entity-level lineage.
 * * `datalineage.events.getFields` permission for the project where the link
 * is stored for column-level lineage.
 *
 * This method also returns processes that created the links if explicitly
 * requested by setting
 * [max_process_per_link](google.cloud.datacatalog.lineage.v1.SearchLineageStreamingRequest.limits.max_process_per_link)
 * is non-zero and full process details are requested via
 * `links.processes.process` in the
 * [FieldMask](https://developers.google.com/workspace/docs/api/how-tos/field-masks#read_with_a_field_mask).
 *
 * Permission required to retrieve processes:
 * * `datalineage.processes.get` permission for the project where the process
 * is stored.
 *
 * @param string $formattedParent  The project and location to initiate the search from. Please see
 *                                 {@see LineageClient::locationName()} for help formatting this field.
 * @param string $locationsElement The locations to search in.
 * @param int    $direction        Direction of the search.
 */
function search_lineage_streaming_sample(
    string $formattedParent,
    string $locationsElement,
    int $direction
): void {
    // Create a client.
    $lineageClient = new LineageClient();

    // Prepare the request message.
    $locations = [$locationsElement,];
    $rootCriteria = new RootCriteria();
    $request = (new SearchLineageStreamingRequest())
        ->setParent($formattedParent)
        ->setLocations($locations)
        ->setRootCriteria($rootCriteria)
        ->setDirection($direction);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $lineageClient->searchLineageStreaming($request);

        /** @var SearchLineageStreamingResponse $element */
        foreach ($stream->readAll() as $element) {
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
    $formattedParent = LineageClient::locationName('[PROJECT]', '[LOCATION]');
    $locationsElement = '[LOCATIONS]';
    $direction = SearchDirection::SEARCH_DIRECTION_UNSPECIFIED;

    search_lineage_streaming_sample($formattedParent, $locationsElement, $direction);
}
// [END datalineage_v1_generated_Lineage_SearchLineageStreaming_sync]
