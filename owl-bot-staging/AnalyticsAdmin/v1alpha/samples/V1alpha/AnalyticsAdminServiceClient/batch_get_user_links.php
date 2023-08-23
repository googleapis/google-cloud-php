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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchGetUserLinks_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\BatchGetUserLinksResponse;
use Google\ApiCore\ApiException;

/**
 * Gets information about multiple users' links to an account or property.
 *
 * @param string $formattedParent       The account or property that all user links in the request are
 *                                      for. The parent of all provided values for the 'names' field must match
 *                                      this field.
 *                                      Example format: accounts/1234
 *                                      Please see {@see AnalyticsAdminServiceClient::accountName()} for help formatting this field.
 * @param string $formattedNamesElement The names of the user links to retrieve.
 *                                      A maximum of 1000 user links can be retrieved in a batch.
 *                                      Format: accounts/{accountId}/userLinks/{userLinkId}
 *                                      Please see {@see AnalyticsAdminServiceClient::userLinkName()} for help formatting this field.
 */
function batch_get_user_links_sample(string $formattedParent, string $formattedNamesElement): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedNames = [$formattedNamesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchGetUserLinksResponse $response */
        $response = $analyticsAdminServiceClient->batchGetUserLinks($formattedParent, $formattedNames);
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
    $formattedParent = AnalyticsAdminServiceClient::accountName('[ACCOUNT]');
    $formattedNamesElement = AnalyticsAdminServiceClient::userLinkName('[ACCOUNT]', '[USER_LINK]');

    batch_get_user_links_sample($formattedParent, $formattedNamesElement);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchGetUserLinks_sync]
