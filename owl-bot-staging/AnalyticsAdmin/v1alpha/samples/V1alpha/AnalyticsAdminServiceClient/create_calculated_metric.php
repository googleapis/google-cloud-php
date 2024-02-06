<?php
/*
 * Copyright 2024 Google LLC
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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateCalculatedMetric_sync]
use Google\Analytics\Admin\V1alpha\CalculatedMetric;
use Google\Analytics\Admin\V1alpha\CalculatedMetric\MetricUnit;
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\CreateCalculatedMetricRequest;
use Google\ApiCore\ApiException;

/**
 * Creates a CalculatedMetric.
 *
 * @param string $formattedParent             Format: properties/{property_id}
 *                                            Example: properties/1234
 *                                            Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param string $calculatedMetricId          The ID to use for the calculated metric which will become the
 *                                            final component of the calculated metric's resource name.
 *
 *                                            This value should be 1-80 characters and valid characters are
 *                                            /[a-zA-Z0-9_]/, no spaces allowed. calculated_metric_id must be unique
 *                                            between all calculated metrics under a property. The calculated_metric_id
 *                                            is used when referencing this calculated metric from external APIs, for
 *                                            example, "calcMetric:{calculated_metric_id}".
 * @param string $calculatedMetricDisplayName Display name for this calculated metric as shown in the
 *                                            Google Analytics UI. Max length 82 characters.
 * @param int    $calculatedMetricMetricUnit  The type for the calculated metric's value.
 * @param string $calculatedMetricFormula     The calculated metric's definition. Maximum number of unique
 *                                            referenced custom metrics is 5. Formulas supports the following operations:
 *                                            + (addition),  - (subtraction), - (negative),  * (multiplication), /
 *                                            (division), () (parenthesis). Any valid real numbers are acceptable that
 *                                            fit in a Long (64bit integer) or a Double (64 bit floating point number).
 *                                            Example formula:
 *                                            "( customEvent:parameter_name + cartPurchaseQuantity ) / 2.0"
 */
function create_calculated_metric_sample(
    string $formattedParent,
    string $calculatedMetricId,
    string $calculatedMetricDisplayName,
    int $calculatedMetricMetricUnit,
    string $calculatedMetricFormula
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $calculatedMetric = (new CalculatedMetric())
        ->setDisplayName($calculatedMetricDisplayName)
        ->setMetricUnit($calculatedMetricMetricUnit)
        ->setFormula($calculatedMetricFormula);
    $request = (new CreateCalculatedMetricRequest())
        ->setParent($formattedParent)
        ->setCalculatedMetricId($calculatedMetricId)
        ->setCalculatedMetric($calculatedMetric);

    // Call the API and handle any network failures.
    try {
        /** @var CalculatedMetric $response */
        $response = $analyticsAdminServiceClient->createCalculatedMetric($request);
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
    $calculatedMetricId = '[CALCULATED_METRIC_ID]';
    $calculatedMetricDisplayName = '[DISPLAY_NAME]';
    $calculatedMetricMetricUnit = MetricUnit::METRIC_UNIT_UNSPECIFIED;
    $calculatedMetricFormula = '[FORMULA]';

    create_calculated_metric_sample(
        $formattedParent,
        $calculatedMetricId,
        $calculatedMetricDisplayName,
        $calculatedMetricMetricUnit,
        $calculatedMetricFormula
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateCalculatedMetric_sync]
