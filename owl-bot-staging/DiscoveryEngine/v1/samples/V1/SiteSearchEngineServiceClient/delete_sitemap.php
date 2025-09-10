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

// [START discoveryengine_v1_generated_SiteSearchEngineService_DeleteSitemap_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DeleteSitemapRequest;
use Google\Rpc\Status;

/**
 * Deletes a [Sitemap][google.cloud.discoveryengine.v1.Sitemap].
 *
 * @param string $formattedName Full resource name of
 *                              [Sitemap][google.cloud.discoveryengine.v1.Sitemap], such as
 *                              `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine/sitemaps/{sitemap}`.
 *
 *                              If the caller does not have permission to access the
 *                              [Sitemap][google.cloud.discoveryengine.v1.Sitemap], regardless of whether
 *                              or not it exists, a PERMISSION_DENIED error is returned.
 *
 *                              If the requested [Sitemap][google.cloud.discoveryengine.v1.Sitemap] does
 *                              not exist, a NOT_FOUND error is returned. Please see
 *                              {@see SiteSearchEngineServiceClient::sitemapName()} for help formatting this field.
 */
function delete_sitemap_sample(string $formattedName): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new DeleteSitemapRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $siteSearchEngineServiceClient->deleteSitemap($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = SiteSearchEngineServiceClient::sitemapName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]',
        '[SITEMAP]'
    );

    delete_sitemap_sample($formattedName);
}
// [END discoveryengine_v1_generated_SiteSearchEngineService_DeleteSitemap_sync]
