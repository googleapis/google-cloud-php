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

// [START admanager_v1_generated_SiteService_BatchUpdateSites_sync]
use Google\Ads\AdManager\V1\BatchUpdateSitesRequest;
use Google\Ads\AdManager\V1\BatchUpdateSitesResponse;
use Google\Ads\AdManager\V1\Client\SiteServiceClient;
use Google\Ads\AdManager\V1\Site;
use Google\Ads\AdManager\V1\UpdateSiteRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to batch update `Site` objects.
 *
 * @param string $formattedParent The parent resource where `Sites` will be updated.
 *                                Format: `networks/{network_code}`
 *                                The parent field in the UpdateSiteRequest must match this
 *                                field. Please see
 *                                {@see SiteServiceClient::networkName()} for help formatting this field.
 * @param string $requestsSiteUrl The URL of the Site.
 */
function batch_update_sites_sample(string $formattedParent, string $requestsSiteUrl): void
{
    // Create a client.
    $siteServiceClient = new SiteServiceClient();

    // Prepare the request message.
    $requestsSite = (new Site())
        ->setUrl($requestsSiteUrl);
    $requestsUpdateMask = new FieldMask();
    $updateSiteRequest = (new UpdateSiteRequest())
        ->setSite($requestsSite)
        ->setUpdateMask($requestsUpdateMask);
    $requests = [$updateSiteRequest,];
    $request = (new BatchUpdateSitesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateSitesResponse $response */
        $response = $siteServiceClient->batchUpdateSites($request);
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
    $formattedParent = SiteServiceClient::networkName('[NETWORK_CODE]');
    $requestsSiteUrl = '[URL]';

    batch_update_sites_sample($formattedParent, $requestsSiteUrl);
}
// [END admanager_v1_generated_SiteService_BatchUpdateSites_sync]
