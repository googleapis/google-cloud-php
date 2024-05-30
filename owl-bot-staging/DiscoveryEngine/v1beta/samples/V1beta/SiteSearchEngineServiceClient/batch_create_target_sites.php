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

// [START discoveryengine_v1beta_generated_SiteSearchEngineService_BatchCreateTargetSites_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\BatchCreateTargetSitesRequest;
use Google\Cloud\DiscoveryEngine\V1beta\BatchCreateTargetSitesResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\CreateTargetSiteRequest;
use Google\Cloud\DiscoveryEngine\V1beta\TargetSite;
use Google\Rpc\Status;

/**
 * Creates [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite] in a
 * batch.
 *
 * @param string $formattedParent                      The parent resource shared by all TargetSites being created.
 *                                                     `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`.
 *                                                     The parent field in the CreateBookRequest messages must either be empty or
 *                                                     match this field. Please see
 *                                                     {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 * @param string $formattedRequestsParent              Parent resource name of
 *                                                     [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite], such as
 *                                                     `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`. Please see
 *                                                     {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 * @param string $requestsTargetSiteProvidedUriPattern Input only. The user provided URI pattern from which the
 *                                                     `generated_uri_pattern` is generated.
 */
function batch_create_target_sites_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsTargetSiteProvidedUriPattern
): void {
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $requestsTargetSite = (new TargetSite())
        ->setProvidedUriPattern($requestsTargetSiteProvidedUriPattern);
    $createTargetSiteRequest = (new CreateTargetSiteRequest())
        ->setParent($formattedRequestsParent)
        ->setTargetSite($requestsTargetSite);
    $requests = [$createTargetSiteRequest,];
    $request = (new BatchCreateTargetSitesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $siteSearchEngineServiceClient->batchCreateTargetSites($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchCreateTargetSitesResponse $result */
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
    $formattedParent = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $formattedRequestsParent = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $requestsTargetSiteProvidedUriPattern = '[PROVIDED_URI_PATTERN]';

    batch_create_target_sites_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsTargetSiteProvidedUriPattern
    );
}
// [END discoveryengine_v1beta_generated_SiteSearchEngineService_BatchCreateTargetSites_sync]
