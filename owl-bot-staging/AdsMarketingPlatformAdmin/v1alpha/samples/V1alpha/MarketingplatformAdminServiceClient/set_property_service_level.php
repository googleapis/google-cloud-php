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

// [START marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_SetPropertyServiceLevel_sync]
use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsServiceLevel;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelResponse;
use Google\ApiCore\ApiException;

/**
 * Updates the service level for an Analytics property.
 *
 * @param string $analyticsAccountLink       The parent AnalyticsAccountLink scope where this property is in.
 *                                           Format:
 *                                           organizations/{org_id}/analyticsAccountLinks/{analytics_account_link_id}
 * @param string $formattedAnalyticsProperty The Analytics property to change the ServiceLevel setting. This
 *                                           field is the name of the Google Analytics Admin API property resource.
 *
 *                                           Format: analyticsadmin.googleapis.com/properties/{property_id}
 *                                           Please see {@see MarketingplatformAdminServiceClient::propertyName()} for help formatting this field.
 * @param int    $serviceLevel               The service level to set for this property.
 */
function set_property_service_level_sample(
    string $analyticsAccountLink,
    string $formattedAnalyticsProperty,
    int $serviceLevel
): void {
    // Create a client.
    $marketingplatformAdminServiceClient = new MarketingplatformAdminServiceClient();

    // Prepare the request message.
    $request = (new SetPropertyServiceLevelRequest())
        ->setAnalyticsAccountLink($analyticsAccountLink)
        ->setAnalyticsProperty($formattedAnalyticsProperty)
        ->setServiceLevel($serviceLevel);

    // Call the API and handle any network failures.
    try {
        /** @var SetPropertyServiceLevelResponse $response */
        $response = $marketingplatformAdminServiceClient->setPropertyServiceLevel($request);
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
    $analyticsAccountLink = '[ANALYTICS_ACCOUNT_LINK]';
    $formattedAnalyticsProperty = MarketingplatformAdminServiceClient::propertyName('[PROPERTY]');
    $serviceLevel = AnalyticsServiceLevel::ANALYTICS_SERVICE_LEVEL_UNSPECIFIED;

    set_property_service_level_sample(
        $analyticsAccountLink,
        $formattedAnalyticsProperty,
        $serviceLevel
    );
}
// [END marketingplatformadmin_v1alpha_generated_MarketingplatformAdminService_SetPropertyServiceLevel_sync]
