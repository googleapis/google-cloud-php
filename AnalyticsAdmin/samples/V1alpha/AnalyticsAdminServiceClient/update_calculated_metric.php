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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateCalculatedMetric_sync]
use Google\Analytics\Admin\V1alpha\CalculatedMetric;
use Google\Analytics\Admin\V1alpha\CalculatedMetric\MetricUnit;
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\UpdateCalculatedMetricRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * Updates a CalculatedMetric on a property.
 *
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
function update_calculated_metric_sample(
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
    $updateMask = new FieldMask();
    $request = (new UpdateCalculatedMetricRequest())
        ->setCalculatedMetric($calculatedMetric)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var CalculatedMetric $response */
        $response = $analyticsAdminServiceClient->updateCalculatedMetric($request);
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
    $calculatedMetricDisplayName = '[DISPLAY_NAME]';
    $calculatedMetricMetricUnit = MetricUnit::METRIC_UNIT_UNSPECIFIED;
    $calculatedMetricFormula = '[FORMULA]';

    update_calculated_metric_sample(
        $calculatedMetricDisplayName,
        $calculatedMetricMetricUnit,
        $calculatedMetricFormula
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateCalculatedMetric_sync]
