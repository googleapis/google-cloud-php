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

// [START datamanager_v1_generated_UserListGlobalLicenseService_ListUserListGlobalLicenses_sync]
use Google\Ads\DataManager\V1\Client\UserListGlobalLicenseServiceClient;
use Google\Ads\DataManager\V1\ListUserListGlobalLicensesRequest;
use Google\Ads\DataManager\V1\UserListGlobalLicense;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Lists all user list global licenses owned by the parent account.
 *
 * This feature is only available to data partners.
 *
 * @param string $formattedParent The account whose licenses are being queried. Should be in the
 *                                format accountTypes/{ACCOUNT_TYPE}/accounts/{ACCOUNT_ID}
 *                                Please see {@see UserListGlobalLicenseServiceClient::accountName()} for help formatting this field.
 */
function list_user_list_global_licenses_sample(string $formattedParent): void
{
    // Create a client.
    $userListGlobalLicenseServiceClient = new UserListGlobalLicenseServiceClient();

    // Prepare the request message.
    $request = (new ListUserListGlobalLicensesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $userListGlobalLicenseServiceClient->listUserListGlobalLicenses($request);

        /** @var UserListGlobalLicense $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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
    $formattedParent = UserListGlobalLicenseServiceClient::accountName('[ACCOUNT_TYPE]', '[ACCOUNT]');

    list_user_list_global_licenses_sample($formattedParent);
}
// [END datamanager_v1_generated_UserListGlobalLicenseService_ListUserListGlobalLicenses_sync]
