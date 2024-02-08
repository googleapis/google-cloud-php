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

// [START discoveryengine_v1beta_generated_SiteSearchEngineService_GetTargetSite_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1beta\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\GetTargetSiteRequest;
use Google\Cloud\DiscoveryEngine\V1beta\TargetSite;

/**
 * Gets a [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite].
 *
 * @param string $formattedName Full resource name of
 *                              [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite], such as
 *                              `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine/targetSites/{target_site}`.
 *
 *                              If the caller does not have permission to access the
 *                              [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite], regardless of
 *                              whether or not it exists, a PERMISSION_DENIED error is returned.
 *
 *                              If the requested
 *                              [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite] does not
 *                              exist, a NOT_FOUND error is returned. Please see
 *                              {@see SiteSearchEngineServiceClient::targetSiteName()} for help formatting this field.
 */
function get_target_site_sample(string $formattedName): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new GetTargetSiteRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var TargetSite $response */
        $response = $siteSearchEngineServiceClient->getTargetSite($request);
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
    $formattedName = SiteSearchEngineServiceClient::targetSiteName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[TARGET_SITE]'
    );

    get_target_site_sample($formattedName);
}
// [END discoveryengine_v1beta_generated_SiteSearchEngineService_GetTargetSite_sync]
