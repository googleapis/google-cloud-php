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

// [START discoveryengine_v1_generated_SiteSearchEngineService_ListTargetSites_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\ListTargetSitesRequest;
use Google\Cloud\DiscoveryEngine\V1\TargetSite;

/**
 * Gets a list of [TargetSite][google.cloud.discoveryengine.v1.TargetSite]s.
 *
 * @param string $formattedParent The parent site search engine resource name, such as
 *                                `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`.
 *
 *                                If the caller does not have permission to list
 *                                [TargetSite][google.cloud.discoveryengine.v1.TargetSite]s under this site
 *                                search engine, regardless of whether or not this branch exists, a
 *                                PERMISSION_DENIED error is returned. Please see
 *                                {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 */
function list_target_sites_sample(string $formattedParent): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new ListTargetSitesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $siteSearchEngineServiceClient->listTargetSites($request);

        /** @var TargetSite $element */
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
    $formattedParent = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );

    list_target_sites_sample($formattedParent);
}
// [END discoveryengine_v1_generated_SiteSearchEngineService_ListTargetSites_sync]
