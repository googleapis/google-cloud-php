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

// [START servicecontrol_v1_generated_ServiceController_Report_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceControl\V1\ReportResponse;
use Google\Cloud\ServiceControl\V1\ServiceControllerClient;

/**
 * Reports operation results to Google Service Control, such as logs and
 * metrics. It should be called after an operation is completed.
 *
 * If feasible, the client should aggregate reporting data for up to 5
 * seconds to reduce API traffic. Limiting aggregation to 5 seconds is to
 * reduce data loss during client crashes. Clients should carefully choose
 * the aggregation time window to avoid data loss risk more than 0.01%
 * for business and compliance reasons.
 *
 * NOTE: the [ReportRequest][google.api.servicecontrol.v1.ReportRequest] has
 * the size limit (wire-format byte size) of 1MB.
 *
 * This method requires the `servicemanagement.services.report` permission
 * on the specified service. For more information, see
 * [Google Cloud IAM](https://cloud.google.com/iam).
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function report_sample(): void
{
    // Create a client.
    $serviceControllerClient = new ServiceControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var ReportResponse $response */
        $response = $serviceControllerClient->report();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END servicecontrol_v1_generated_ServiceController_Report_sync]
