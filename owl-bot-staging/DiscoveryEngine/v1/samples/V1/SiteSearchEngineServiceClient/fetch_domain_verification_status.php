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

// [START discoveryengine_v1_generated_SiteSearchEngineService_FetchDomainVerificationStatus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\FetchDomainVerificationStatusRequest;
use Google\Cloud\DiscoveryEngine\V1\TargetSite;

/**
 * Returns list of target sites with its domain verification status.
 * This method can only be called under data store with BASIC_SITE_SEARCH
 * state at the moment.
 *
 * @param string $formattedSiteSearchEngine The site search engine resource under which we fetch all the
 *                                          domain verification status.
 *                                          `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`. Please see
 *                                          {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 */
function fetch_domain_verification_status_sample(string $formattedSiteSearchEngine): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new FetchDomainVerificationStatusRequest())
        ->setSiteSearchEngine($formattedSiteSearchEngine);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $siteSearchEngineServiceClient->fetchDomainVerificationStatus($request);

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
    $formattedSiteSearchEngine = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );

    fetch_domain_verification_status_sample($formattedSiteSearchEngine);
}
// [END discoveryengine_v1_generated_SiteSearchEngineService_FetchDomainVerificationStatus_sync]
