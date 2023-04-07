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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateDisplayVideo360AdvertiserLink_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLink;
use Google\ApiCore\ApiException;

/**
 * Creates a DisplayVideo360AdvertiserLink.
 * This can only be utilized by users who have proper authorization both on
 * the Google Analytics property and on the Display & Video 360 advertiser.
 * Users who do not have access to the Display & Video 360 advertiser should
 * instead seek to create a DisplayVideo360LinkProposal.
 *
 * @param string $formattedParent Example format: properties/1234
 *                                Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 */
function create_display_video360_advertiser_link_sample(string $formattedParent): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $displayVideo360AdvertiserLink = new DisplayVideo360AdvertiserLink();

    // Call the API and handle any network failures.
    try {
        /** @var DisplayVideo360AdvertiserLink $response */
        $response = $analyticsAdminServiceClient->createDisplayVideo360AdvertiserLink(
            $formattedParent,
            $displayVideo360AdvertiserLink
        );
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
    $formattedParent = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');

    create_display_video360_advertiser_link_sample($formattedParent);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateDisplayVideo360AdvertiserLink_sync]
