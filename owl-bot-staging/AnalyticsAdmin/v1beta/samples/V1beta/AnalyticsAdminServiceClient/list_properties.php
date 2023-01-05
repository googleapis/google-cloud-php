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

// [START analyticsadmin_v1beta_generated_AnalyticsAdminService_ListProperties_sync]
use Google\Analytics\Admin\V1beta\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1beta\Property;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Returns child Properties under the specified parent Account.
 *
 * Only "GA4" properties will be returned.
 * Properties will be excluded if the caller does not have access.
 * Soft-deleted (ie: "trashed") properties are excluded by default.
 * Returns an empty list if no relevant properties are found.
 *
 * @param string $filter An expression for filtering the results of the request.
 *                       Fields eligible for filtering are:
 *                       `parent:`(The resource name of the parent account/property) or
 *                       `ancestor:`(The resource name of the parent account) or
 *                       `firebase_project:`(The id or number of the linked firebase project).
 *                       Some examples of filters:
 *
 *                       ```
 *                       | Filter                      | Description                               |
 *                       |-----------------------------|-------------------------------------------|
 *                       | parent:accounts/123         | The account with account id: 123.       |
 *                       | parent:properties/123       | The property with property id: 123.       |
 *                       | ancestor:accounts/123       | The account with account id: 123.         |
 *                       | firebase_project:project-id | The firebase project with id: project-id. |
 *                       | firebase_project:123        | The firebase project with number: 123.    |
 *                       ```
 */
function list_properties_sample(string $filter): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $analyticsAdminServiceClient->listProperties($filter);

        /** @var Property $element */
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
    $filter = '[FILTER]';

    list_properties_sample($filter);
}
// [END analyticsadmin_v1beta_generated_AnalyticsAdminService_ListProperties_sync]
