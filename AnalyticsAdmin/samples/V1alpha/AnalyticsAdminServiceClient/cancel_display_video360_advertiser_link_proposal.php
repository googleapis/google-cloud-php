<?php
/*
 * Copyright 2022 Google LLC
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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CancelDisplayVideo360AdvertiserLinkProposal_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\DisplayVideo360AdvertiserLinkProposal;
use Google\ApiCore\ApiException;

/**
 * Cancels a DisplayVideo360AdvertiserLinkProposal.
 * Cancelling can mean either:
 * - Declining a proposal initiated from Display & Video 360
 * - Withdrawing a proposal initiated from Google Analytics
 * After being cancelled, a proposal will eventually be deleted automatically.
 *
 * @param string $formattedName The name of the DisplayVideo360AdvertiserLinkProposal to cancel.
 *                              Example format: properties/1234/displayVideo360AdvertiserLinkProposals/5678
 *                              Please see {@see AnalyticsAdminServiceClient::displayVideo360AdvertiserLinkProposalName()} for help formatting this field.
 */
function cancel_display_video360_advertiser_link_proposal_sample(string $formattedName): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var DisplayVideo360AdvertiserLinkProposal $response */
        $response = $analyticsAdminServiceClient->cancelDisplayVideo360AdvertiserLinkProposal(
            $formattedName
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
    $formattedName = AnalyticsAdminServiceClient::displayVideo360AdvertiserLinkProposalName(
        '[PROPERTY]',
        '[DISPLAY_VIDEO_360_ADVERTISER_LINK_PROPOSAL]'
    );

    cancel_display_video360_advertiser_link_proposal_sample($formattedName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CancelDisplayVideo360AdvertiserLinkProposal_sync]
