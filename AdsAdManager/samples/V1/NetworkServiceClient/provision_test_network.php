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

// [START admanager_v1_generated_NetworkService_ProvisionTestNetwork_sync]
use Google\Ads\AdManager\V1\Client\NetworkServiceClient;
use Google\Ads\AdManager\V1\Network;
use Google\Ads\AdManager\V1\ProvisionTestNetworkRequest;
use Google\ApiCore\ApiException;

/**
 * Provisions a test network associated with the current user. Only one test
 * network can be provisioned per user.
 *
 * Before the test network can be used, you must complete setup in the Ad
 * Manager UI. If the test network's owner is a service account, you must add
 * a non-service account user by calling UserService.CreateUser.
 *
 * Test networks are limited in the following ways:
 *
 * * Test networks have a maximum of 10,000 objects per entity type.
 * * Test networks cannot serve ads.
 * * Reports on serving data have zero rows.
 * * Forecast service results contain mock data.
 * * Test networks do not have Ad Manager 360 or premium features enabled.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function provision_test_network_sample(): void
{
    // Create a client.
    $networkServiceClient = new NetworkServiceClient();

    // Prepare the request message.
    $request = new ProvisionTestNetworkRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Network $response */
        $response = $networkServiceClient->provisionTestNetwork($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END admanager_v1_generated_NetworkService_ProvisionTestNetwork_sync]
