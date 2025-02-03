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

// [START marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_CreateAnalyticsAccountLink_sync]
use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsAccountLink;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateAnalyticsAccountLinkRequest;
use Google\ApiCore\ApiException;

/**
 * Creates the link between the Analytics account and the Google Marketing
 * Platform organization.
 *
 * User needs to be an org user, and admin on the Analytics account to create
 * the link. If the account is already linked to an organization, user needs
 * to unlink the account from the current organization, then try link again.
 *
 * @param string $formattedParent                               The parent resource where this Analytics account link will be
 *                                                              created. Format: organizations/{org_id}
 *                                                              Please see {@see MarketingplatformAdminServiceClient::organizationName()} for help formatting this field.
 * @param string $formattedAnalyticsAccountLinkAnalyticsAccount Immutable. The resource name of the AnalyticsAdmin API account.
 *                                                              The account ID will be used as the ID of this AnalyticsAccountLink
 *                                                              resource, which will become the final component of the resource name.
 *
 *                                                              Format: analyticsadmin.googleapis.com/accounts/{account_id}
 *                                                              Please see {@see MarketingplatformAdminServiceClient::accountName()} for help formatting this field.
 */
function create_analytics_account_link_sample(
    string $formattedParent,
    string $formattedAnalyticsAccountLinkAnalyticsAccount
): void {
    // Create a client.
    $marketingplatformAdminServiceClient = new MarketingplatformAdminServiceClient();

    // Prepare the request message.
    $analyticsAccountLink = (new AnalyticsAccountLink())
        ->setAnalyticsAccount($formattedAnalyticsAccountLinkAnalyticsAccount);
    $request = (new CreateAnalyticsAccountLinkRequest())
        ->setParent($formattedParent)
        ->setAnalyticsAccountLink($analyticsAccountLink);

    // Call the API and handle any network failures.
    try {
        /** @var AnalyticsAccountLink $response */
        $response = $marketingplatformAdminServiceClient->createAnalyticsAccountLink($request);
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
    $formattedParent = MarketingplatformAdminServiceClient::organizationName('[ORGANIZATION]');
    $formattedAnalyticsAccountLinkAnalyticsAccount = MarketingplatformAdminServiceClient::accountName(
        '[ACCOUNT]'
    );

    create_analytics_account_link_sample(
        $formattedParent,
        $formattedAnalyticsAccountLinkAnalyticsAccount
    );
}
// [END marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_CreateAnalyticsAccountLink_sync]
