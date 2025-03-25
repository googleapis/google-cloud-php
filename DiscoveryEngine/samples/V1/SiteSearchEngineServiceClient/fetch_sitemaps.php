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

// [START discoveryengine_v1_generated_SiteSearchEngineService_FetchSitemaps_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\FetchSitemapsRequest;
use Google\Cloud\DiscoveryEngine\V1\FetchSitemapsResponse;

/**
 * Fetch [Sitemap][google.cloud.discoveryengine.v1.Sitemap]s in a
 * [DataStore][google.cloud.discoveryengine.v1.DataStore].
 *
 * @param string $formattedParent Parent resource name of the
 *                                [SiteSearchEngine][google.cloud.discoveryengine.v1.SiteSearchEngine], such
 *                                as `projects/&#42;/locations/&#42;/collections/&#42;/dataStores/&#42;/siteSearchEngine`. Please see
 *                                {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 */
function fetch_sitemaps_sample(string $formattedParent): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new FetchSitemapsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var FetchSitemapsResponse $response */
        $response = $siteSearchEngineServiceClient->fetchSitemaps($request);
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
    $formattedParent = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );

    fetch_sitemaps_sample($formattedParent);
}
// [END discoveryengine_v1_generated_SiteSearchEngineService_FetchSitemaps_sync]
