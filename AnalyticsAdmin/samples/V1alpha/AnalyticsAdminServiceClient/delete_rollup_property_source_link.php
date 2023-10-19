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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_DeleteRollupPropertySourceLink_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\ApiCore\ApiException;

/**
 * Deletes a roll-up property source link.
 * Only roll-up properties can have source links, so this method will throw an
 * error if used on other types of properties.
 *
 * @param string $formattedName Format:
 *                              properties/{property_id}/rollupPropertySourceLinks/{rollup_property_source_link_id}
 *                              Example: properties/1234/rollupPropertySourceLinks/5678
 *                              Please see {@see AnalyticsAdminServiceClient::rollupPropertySourceLinkName()} for help formatting this field.
 */
function delete_rollup_property_source_link_sample(string $formattedName): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        $analyticsAdminServiceClient->deleteRollupPropertySourceLink($formattedName);
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
    $formattedName = AnalyticsAdminServiceClient::rollupPropertySourceLinkName(
        '[PROPERTY]',
        '[ROLLUP_PROPERTY_SOURCE_LINK]'
    );

    delete_rollup_property_source_link_sample($formattedName);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_DeleteRollupPropertySourceLink_sync]
