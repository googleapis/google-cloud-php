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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateCustomMetric_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\CustomMetric;
use Google\Analytics\Admin\V1alpha\CustomMetric\MeasurementUnit;
use Google\Analytics\Admin\V1alpha\CustomMetric\MetricScope;
use Google\ApiCore\ApiException;

/**
 * Creates a CustomMetric.
 *
 * @param string $formattedParent             Example format: properties/1234
 *                                            Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param string $customMetricParameterName   Immutable. Tagging name for this custom metric.
 *
 *                                            If this is an event-scoped metric, then this is the event parameter
 *                                            name.
 *
 *                                            May only contain alphanumeric and underscore charactes, starting with a
 *                                            letter. Max length of 40 characters for event-scoped metrics.
 * @param string $customMetricDisplayName     Display name for this custom metric as shown in the Analytics UI.
 *                                            Max length of 82 characters, alphanumeric plus space and underscore
 *                                            starting with a letter. Legacy system-generated display names may contain
 *                                            square brackets, but updates to this field will never permit square
 *                                            brackets.
 * @param int    $customMetricMeasurementUnit The type for the custom metric's value.
 * @param int    $customMetricScope           Immutable. The scope of this custom metric.
 */
function create_custom_metric_sample(
    string $formattedParent,
    string $customMetricParameterName,
    string $customMetricDisplayName,
    int $customMetricMeasurementUnit,
    int $customMetricScope
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $customMetric = (new CustomMetric())
        ->setParameterName($customMetricParameterName)
        ->setDisplayName($customMetricDisplayName)
        ->setMeasurementUnit($customMetricMeasurementUnit)
        ->setScope($customMetricScope);

    // Call the API and handle any network failures.
    try {
        /** @var CustomMetric $response */
        $response = $analyticsAdminServiceClient->createCustomMetric($formattedParent, $customMetric);
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
    $customMetricParameterName = '[PARAMETER_NAME]';
    $customMetricDisplayName = '[DISPLAY_NAME]';
    $customMetricMeasurementUnit = MeasurementUnit::MEASUREMENT_UNIT_UNSPECIFIED;
    $customMetricScope = MetricScope::METRIC_SCOPE_UNSPECIFIED;

    create_custom_metric_sample(
        $formattedParent,
        $customMetricParameterName,
        $customMetricDisplayName,
        $customMetricMeasurementUnit,
        $customMetricScope
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateCustomMetric_sync]
