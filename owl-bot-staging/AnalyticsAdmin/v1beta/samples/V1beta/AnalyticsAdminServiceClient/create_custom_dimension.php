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

// [START analyticsadmin_v1beta_generated_AnalyticsAdminService_CreateCustomDimension_sync]
use Google\Analytics\Admin\V1beta\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1beta\CustomDimension;
use Google\Analytics\Admin\V1beta\CustomDimension\DimensionScope;
use Google\ApiCore\ApiException;

/**
 * Creates a CustomDimension.
 *
 * @param string $formattedParent              Example format: properties/1234
 *                                             Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param string $customDimensionParameterName Immutable. Tagging parameter name for this custom dimension.
 *
 *                                             If this is a user-scoped dimension, then this is the user property name.
 *                                             If this is an event-scoped dimension, then this is the event parameter
 *                                             name.
 *
 *                                             May only contain alphanumeric and underscore characters, starting with a
 *                                             letter. Max length of 24 characters for user-scoped dimensions, 40
 *                                             characters for event-scoped dimensions.
 * @param string $customDimensionDisplayName   Display name for this custom dimension as shown in the Analytics
 *                                             UI. Max length of 82 characters, alphanumeric plus space and underscore
 *                                             starting with a letter. Legacy system-generated display names may contain
 *                                             square brackets, but updates to this field will never permit square
 *                                             brackets.
 * @param int    $customDimensionScope         Immutable. The scope of this dimension.
 */
function create_custom_dimension_sample(
    string $formattedParent,
    string $customDimensionParameterName,
    string $customDimensionDisplayName,
    int $customDimensionScope
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $customDimension = (new CustomDimension())
        ->setParameterName($customDimensionParameterName)
        ->setDisplayName($customDimensionDisplayName)
        ->setScope($customDimensionScope);

    // Call the API and handle any network failures.
    try {
        /** @var CustomDimension $response */
        $response = $analyticsAdminServiceClient->createCustomDimension($formattedParent, $customDimension);
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
    $formattedParent = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');
    $customDimensionParameterName = '[PARAMETER_NAME]';
    $customDimensionDisplayName = '[DISPLAY_NAME]';
    $customDimensionScope = DimensionScope::DIMENSION_SCOPE_UNSPECIFIED;

    create_custom_dimension_sample(
        $formattedParent,
        $customDimensionParameterName,
        $customDimensionDisplayName,
        $customDimensionScope
    );
}
// [END analyticsadmin_v1beta_generated_AnalyticsAdminService_CreateCustomDimension_sync]
