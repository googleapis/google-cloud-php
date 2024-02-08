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

// [START discoveryengine_v1beta_generated_SiteSearchEngineService_DisableAdvancedSiteSearch_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\DisableAdvancedSiteSearchRequest;
use Google\Cloud\DiscoveryEngine\V1beta\DisableAdvancedSiteSearchResponse;
use Google\Rpc\Status;

/**
 * Downgrade from advanced site search to basic site search.
 *
 * @param string $formattedSiteSearchEngine Full resource name of the
 *                                          [SiteSearchEngine][google.cloud.discoveryengine.v1beta.SiteSearchEngine],
 *                                          such as
 *                                          `projects/{project}/locations/{location}/dataStores/{data_store_id}/siteSearchEngine`. Please see
 *                                          {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 */
function disable_advanced_site_search_sample(string $formattedSiteSearchEngine): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new DisableAdvancedSiteSearchRequest())
        ->setSiteSearchEngine($formattedSiteSearchEngine);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $siteSearchEngineServiceClient->disableAdvancedSiteSearch($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DisableAdvancedSiteSearchResponse $result */
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
    $formattedSiteSearchEngine = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );

    disable_advanced_site_search_sample($formattedSiteSearchEngine);
}
// [END discoveryengine_v1beta_generated_SiteSearchEngineService_DisableAdvancedSiteSearch_sync]
