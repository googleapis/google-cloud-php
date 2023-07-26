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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchDeleteUserLinks_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\DeleteUserLinkRequest;
use Google\ApiCore\ApiException;

/**
 * Deletes information about multiple users' links to an account or property.
 *
 * @param string $formattedParent       The account or property that all user links in the request are
 *                                      for. The parent of all values for user link names to delete must match this
 *                                      field.
 *                                      Example format: accounts/1234
 *                                      Please see {@see AnalyticsAdminServiceClient::accountName()} for help formatting this field.
 * @param string $formattedRequestsName Example format: accounts/1234/userLinks/5678
 *                                      Please see {@see AnalyticsAdminServiceClient::userLinkName()} for help formatting this field.
 */
function batch_delete_user_links_sample(
    string $formattedParent,
    string $formattedRequestsName
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $deleteUserLinkRequest = (new DeleteUserLinkRequest())
        ->setName($formattedRequestsName);
    $requests = [$deleteUserLinkRequest,];

    // Call the API and handle any network failures.
    try {
        $analyticsAdminServiceClient->batchDeleteUserLinks($formattedParent, $requests);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedRequestsName = AnalyticsAdminServiceClient::userLinkName('[ACCOUNT]', '[USER_LINK]');

    batch_delete_user_links_sample($formattedParent, $formattedRequestsName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchDeleteUserLinks_sync]
