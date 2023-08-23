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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchCreateUserLinks_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\BatchCreateUserLinksResponse;
use Google\Analytics\Admin\V1alpha\CreateUserLinkRequest;
use Google\Analytics\Admin\V1alpha\UserLink;
use Google\ApiCore\ApiException;

/**
 * Creates information about multiple users' links to an account or property.
 *
 * This method is transactional. If any UserLink cannot be created, none of
 * the UserLinks will be created.
 *
 * @param string $formattedParent         The account or property that all user links in the request are
 *                                        for. This field is required. The parent field in the CreateUserLinkRequest
 *                                        messages must either be empty or match this field.
 *                                        Example format: accounts/1234
 *                                        Please see {@see AnalyticsAdminServiceClient::accountName()} for help formatting this field.
 * @param string $formattedRequestsParent Example format: accounts/1234
 *                                        Please see {@see AnalyticsAdminServiceClient::accountName()} for help formatting this field.
 */
function batch_create_user_links_sample(
    string $formattedParent,
    string $formattedRequestsParent
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestsUserLink = new UserLink();
    $createUserLinkRequest = (new CreateUserLinkRequest())
        ->setParent($formattedRequestsParent)
        ->setUserLink($requestsUserLink);
    $requests = [$createUserLinkRequest,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateUserLinksResponse $response */
        $response = $analyticsAdminServiceClient->batchCreateUserLinks($formattedParent, $requests);
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
    $formattedRequestsParent = AnalyticsAdminServiceClient::accountName('[ACCOUNT]');

    batch_create_user_links_sample($formattedParent, $formattedRequestsParent);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_BatchCreateUserLinks_sync]
