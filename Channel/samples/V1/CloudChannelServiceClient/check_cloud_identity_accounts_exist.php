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

// [START cloudchannel_v1_generated_CloudChannelService_CheckCloudIdentityAccountsExist_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistRequest;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;

/**
 * Confirms the existence of Cloud Identity accounts based on the domain and
 * if the Cloud Identity accounts are owned by the reseller.
 *
 * Possible error codes:
 *
 * * PERMISSION_DENIED: The reseller account making the request is different
 * from the reseller account in the API request.
 * * INVALID_ARGUMENT: Required request parameters are missing or invalid.
 * * INVALID_VALUE: Invalid domain value in the request.
 *
 * Return value:
 * A list of
 * [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount]
 * resources for the domain (may be empty)
 *
 * Note: in the v1alpha1 version of the API, a NOT_FOUND error returns if
 * no
 * [CloudIdentityCustomerAccount][google.cloud.channel.v1.CloudIdentityCustomerAccount]
 * resources match the domain.
 *
 * @param string $parent The reseller account's resource name.
 *                       Parent uses the format: accounts/{account_id}
 * @param string $domain Domain to fetch for Cloud Identity account customer.
 */
function check_cloud_identity_accounts_exist_sample(string $parent, string $domain): void
{
    // Create a client.
    $cloudChannelServiceClient = new CloudChannelServiceClient();

    // Prepare the request message.
    $request = (new CheckCloudIdentityAccountsExistRequest())
        ->setParent($parent)
        ->setDomain($domain);

    // Call the API and handle any network failures.
    try {
        /** @var CheckCloudIdentityAccountsExistResponse $response */
        $response = $cloudChannelServiceClient->checkCloudIdentityAccountsExist($request);
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
    $parent = '[PARENT]';
    $domain = '[DOMAIN]';

    check_cloud_identity_accounts_exist_sample($parent, $domain);
}
// [END cloudchannel_v1_generated_CloudChannelService_CheckCloudIdentityAccountsExist_sync]
