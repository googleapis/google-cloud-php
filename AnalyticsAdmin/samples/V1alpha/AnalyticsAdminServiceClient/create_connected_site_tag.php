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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateConnectedSiteTag_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\ConnectedSiteTag;
use Google\Analytics\Admin\V1alpha\CreateConnectedSiteTagResponse;
use Google\ApiCore\ApiException;

/**
 * Creates a connected site tag for a Universal Analytics property. You can
 * create a maximum of 20 connected site tags per property.
 * Note: This API cannot be used on GA4 properties.
 *
 * @param string $connectedSiteTagDisplayName User-provided display name for the connected site tag. Must be
 *                                            less than 256 characters.
 * @param string $connectedSiteTagTagId       "Tag ID to forward events to. Also known as the Measurement ID,
 *                                            or the "G-ID"  (For example: G-12345).
 */
function create_connected_site_tag_sample(
    string $connectedSiteTagDisplayName,
    string $connectedSiteTagTagId
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $connectedSiteTag = (new ConnectedSiteTag())
        ->setDisplayName($connectedSiteTagDisplayName)
        ->setTagId($connectedSiteTagTagId);

    // Call the API and handle any network failures.
    try {
        /** @var CreateConnectedSiteTagResponse $response */
        $response = $analyticsAdminServiceClient->createConnectedSiteTag($connectedSiteTag);
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
    $connectedSiteTagDisplayName = '[DISPLAY_NAME]';
    $connectedSiteTagTagId = '[TAG_ID]';

    create_connected_site_tag_sample($connectedSiteTagDisplayName, $connectedSiteTagTagId);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateConnectedSiteTag_sync]
