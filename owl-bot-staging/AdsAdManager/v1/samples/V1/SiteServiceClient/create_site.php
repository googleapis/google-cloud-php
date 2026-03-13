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

// [START admanager_v1_generated_SiteService_CreateSite_sync]
use Google\Ads\AdManager\V1\Client\SiteServiceClient;
use Google\Ads\AdManager\V1\CreateSiteRequest;
use Google\Ads\AdManager\V1\Site;
use Google\ApiCore\ApiException;

/**
 * API to create a `Site` object.
 *
 * @param string $formattedParent The parent resource where this `Site` will be created.
 *                                Format: `networks/{network_code}`
 *                                Please see {@see SiteServiceClient::networkName()} for help formatting this field.
 * @param string $siteUrl         The URL of the Site.
 */
function create_site_sample(string $formattedParent, string $siteUrl): void
{
    // Create a client.
    $siteServiceClient = new SiteServiceClient();

    // Prepare the request message.
    $site = (new Site())
        ->setUrl($siteUrl);
    $request = (new CreateSiteRequest())
        ->setParent($formattedParent)
        ->setSite($site);

    // Call the API and handle any network failures.
    try {
        /** @var Site $response */
        $response = $siteServiceClient->createSite($request);
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
    $siteUrl = '[URL]';

    create_site_sample($formattedParent, $siteUrl);
}
// [END admanager_v1_generated_SiteService_CreateSite_sync]
