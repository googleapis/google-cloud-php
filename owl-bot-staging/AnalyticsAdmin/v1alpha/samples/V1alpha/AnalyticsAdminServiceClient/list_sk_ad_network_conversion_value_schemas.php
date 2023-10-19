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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_ListSKAdNetworkConversionValueSchemas_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\SKAdNetworkConversionValueSchema;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Lists SKAdNetworkConversionValueSchema on a stream.
 * Properties can have at most one SKAdNetworkConversionValueSchema.
 *
 * @param string $formattedParent The DataStream resource to list schemas for.
 *                                Format:
 *                                properties/{property_id}/dataStreams/{dataStream}
 *                                Example: properties/1234/dataStreams/5678
 *                                Please see {@see AnalyticsAdminServiceClient::dataStreamName()} for help formatting this field.
 */
function list_sk_ad_network_conversion_value_schemas_sample(string $formattedParent): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $analyticsAdminServiceClient->listSKAdNetworkConversionValueSchemas($formattedParent);

        /** @var SKAdNetworkConversionValueSchema $element */
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
    $formattedParent = AnalyticsAdminServiceClient::dataStreamName('[PROPERTY]', '[DATA_STREAM]');

    list_sk_ad_network_conversion_value_schemas_sample($formattedParent);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_ListSKAdNetworkConversionValueSchemas_sync]
