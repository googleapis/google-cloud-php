<?php
/*
 * Copyright 2026 Google LLC
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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateReportingDataAnnotation_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\ReportingDataAnnotation;
use Google\Analytics\Admin\V1alpha\ReportingDataAnnotation\Color;
use Google\Analytics\Admin\V1alpha\UpdateReportingDataAnnotationRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a Reporting Data Annotation.
 *
 * @param string $reportingDataAnnotationName  Identifier. Resource name of this Reporting Data Annotation.
 *                                             Format:
 *                                             'properties/{property_id}/reportingDataAnnotations/{reporting_data_annotation}'
 *                                             Format: 'properties/123/reportingDataAnnotations/456'
 * @param string $reportingDataAnnotationTitle Human-readable title for this Reporting Data Annotation.
 * @param int    $reportingDataAnnotationColor The color used for display of this Reporting Data Annotation.
 */
function update_reporting_data_annotation_sample(
    string $reportingDataAnnotationName,
    string $reportingDataAnnotationTitle,
    int $reportingDataAnnotationColor
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $reportingDataAnnotation = (new ReportingDataAnnotation())
        ->setName($reportingDataAnnotationName)
        ->setTitle($reportingDataAnnotationTitle)
        ->setColor($reportingDataAnnotationColor);
    $request = (new UpdateReportingDataAnnotationRequest())
        ->setReportingDataAnnotation($reportingDataAnnotation);

    // Call the API and handle any network failures.
    try {
        /** @var ReportingDataAnnotation $response */
        $response = $analyticsAdminServiceClient->updateReportingDataAnnotation($request);
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
    $reportingDataAnnotationName = '[NAME]';
    $reportingDataAnnotationTitle = '[TITLE]';
    $reportingDataAnnotationColor = Color::COLOR_UNSPECIFIED;

    update_reporting_data_annotation_sample(
        $reportingDataAnnotationName,
        $reportingDataAnnotationTitle,
        $reportingDataAnnotationColor
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateReportingDataAnnotation_sync]
