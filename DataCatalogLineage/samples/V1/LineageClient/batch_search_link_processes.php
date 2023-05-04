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

// [START datalineage_v1_generated_Lineage_BatchSearchLinkProcesses_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DataCatalog\Lineage\V1\LineageClient;
use Google\Cloud\DataCatalog\Lineage\V1\ProcessLinks;

/**
 * Retrieve information about LineageProcesses associated with specific
 * links. LineageProcesses are transformation pipelines that result in data
 * flowing from **source** to **target** assets. Links between assets
 * represent this operation.
 *
 * If you have specific link names, you can use this method to
 * verify which LineageProcesses contribute to creating those links.
 * See the
 * [SearchLinks][google.cloud.datacatalog.lineage.v1.Lineage.SearchLinks]
 * method for more information on how to retrieve link name.
 *
 * You can retrieve the LineageProcess information in every project where you
 * have the `datalineage.events.get` permission. The project provided in the
 * URL is used for Billing and Quota.
 *
 * @param string $formattedParent The project and location you want search in the format `projects/&#42;/locations/*`
 *                                Please see {@see LineageClient::locationName()} for help formatting this field.
 * @param string $linksElement    An array of links to check for their associated LineageProcesses.
 *
 *                                The maximum number of items in this array is 100.
 *                                If the request contains more than 100 links, it returns the
 *                                `INVALID_ARGUMENT` error.
 *
 *                                Format: `projects/{project}/locations/{location}/links/{link}`.
 */
function batch_search_link_processes_sample(string $formattedParent, string $linksElement): void
{
    // Create a client.
    $lineageClient = new LineageClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $links = [$linksElement,];

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $lineageClient->batchSearchLinkProcesses($formattedParent, $links);

        /** @var ProcessLinks $element */
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
    $formattedParent = LineageClient::locationName('[PROJECT]', '[LOCATION]');
    $linksElement = '[LINKS]';

    batch_search_link_processes_sample($formattedParent, $linksElement);
}
// [END datalineage_v1_generated_Lineage_BatchSearchLinkProcesses_sync]
