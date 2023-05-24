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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_DeleteProperty_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\Property;
use Google\ApiCore\ApiException;

/**
 * Marks target Property as soft-deleted (ie: "trashed") and returns it.
 *
 * This API does not have a method to restore soft-deleted properties.
 * However, they can be restored using the Trash Can UI.
 *
 * If the properties are not restored before the expiration time, the Property
 * and all child resources (eg: GoogleAdsLinks, Streams, UserLinks)
 * will be permanently purged.
 * https://support.google.com/analytics/answer/6154772
 *
 * Returns an error if the target is not found, or is not a GA4 Property.
 *
 * @param string $formattedName The name of the Property to soft-delete.
 *                              Format: properties/{property_id}
 *                              Example: "properties/1000"
 *                              Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 */
function delete_property_sample(string $formattedName): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Property $response */
        $response = $analyticsAdminServiceClient->deleteProperty($formattedName);
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
    $formattedName = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');

    delete_property_sample($formattedName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_DeleteProperty_sync]
