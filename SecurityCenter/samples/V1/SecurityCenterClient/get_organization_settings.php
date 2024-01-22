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

// [START securitycenter_v1_generated_SecurityCenter_GetOrganizationSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\GetOrganizationSettingsRequest;
use Google\Cloud\SecurityCenter\V1\OrganizationSettings;

/**
 * Gets the settings for an organization.
 *
 * @param string $formattedName Name of the organization to get organization settings for. Its
 *                              format is "organizations/[organization_id]/organizationSettings". Please see
 *                              {@see SecurityCenterClient::organizationSettingsName()} for help formatting this field.
 */
function get_organization_settings_sample(string $formattedName): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $request = (new GetOrganizationSettingsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OrganizationSettings $response */
        $response = $securityCenterClient->getOrganizationSettings($request);
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
    $formattedName = SecurityCenterClient::organizationSettingsName('[ORGANIZATION]');

    get_organization_settings_sample($formattedName);
}
// [END securitycenter_v1_generated_SecurityCenter_GetOrganizationSettings_sync]
