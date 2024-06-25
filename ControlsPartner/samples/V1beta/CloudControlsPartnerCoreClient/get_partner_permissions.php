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

// [START cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_GetPartnerPermissions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudControlsPartner\V1beta\Client\CloudControlsPartnerCoreClient;
use Google\Cloud\CloudControlsPartner\V1beta\GetPartnerPermissionsRequest;
use Google\Cloud\CloudControlsPartner\V1beta\PartnerPermissions;

/**
 * Gets the partner permissions granted for a workload
 *
 * @param string $formattedName Name of the resource to get in the format:
 *                              `organizations/{organization}/locations/{location}/customers/{customer}/workloads/{workload}/partnerPermissions`
 *                              Please see {@see CloudControlsPartnerCoreClient::partnerPermissionsName()} for help formatting this field.
 */
function get_partner_permissions_sample(string $formattedName): void
{
    // Create a client.
    $cloudControlsPartnerCoreClient = new CloudControlsPartnerCoreClient();

    // Prepare the request message.
    $request = (new GetPartnerPermissionsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PartnerPermissions $response */
        $response = $cloudControlsPartnerCoreClient->getPartnerPermissions($request);
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
    $formattedName = CloudControlsPartnerCoreClient::partnerPermissionsName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[CUSTOMER]',
        '[WORKLOAD]'
    );

    get_partner_permissions_sample($formattedName);
}
// [END cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_GetPartnerPermissions_sync]
