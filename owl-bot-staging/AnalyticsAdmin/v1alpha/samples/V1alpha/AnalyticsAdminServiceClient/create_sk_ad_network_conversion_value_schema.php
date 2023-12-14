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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateSKAdNetworkConversionValueSchema_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\PostbackWindow;
use Google\Analytics\Admin\V1alpha\SKAdNetworkConversionValueSchema;
use Google\ApiCore\ApiException;

/**
 * Creates a SKAdNetworkConversionValueSchema.
 *
 * @param string $formattedParent The parent resource where this schema will be created.
 *                                Format: properties/{property}/dataStreams/{dataStream}
 *                                Please see {@see AnalyticsAdminServiceClient::dataStreamName()} for help formatting this field.
 */
function create_sk_ad_network_conversion_value_schema_sample(string $formattedParent): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $skadnetworkConversionValueSchemaPostbackWindowOne = new PostbackWindow();
    $skadnetworkConversionValueSchema = (new SKAdNetworkConversionValueSchema())
        ->setPostbackWindowOne($skadnetworkConversionValueSchemaPostbackWindowOne);

    // Call the API and handle any network failures.
    try {
        /** @var SKAdNetworkConversionValueSchema $response */
        $response = $analyticsAdminServiceClient->createSKAdNetworkConversionValueSchema(
            $formattedParent,
            $skadnetworkConversionValueSchema
        );
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
    $formattedParent = AnalyticsAdminServiceClient::dataStreamName('[PROPERTY]', '[DATA_STREAM]');

    create_sk_ad_network_conversion_value_schema_sample($formattedParent);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateSKAdNetworkConversionValueSchema_sync]
