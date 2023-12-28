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

// [START servicemanagement_v1_generated_ServiceManager_GenerateConfigReport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceManagement\V1\GenerateConfigReportResponse;
use Google\Cloud\ServiceManagement\V1\ServiceManagerClient;
use Google\Protobuf\Any;

/**
 * Generates and returns a report (errors, warnings and changes from
 * existing configurations) associated with
 * GenerateConfigReportRequest.new_value
 *
 * If GenerateConfigReportRequest.old_value is specified,
 * GenerateConfigReportRequest will contain a single ChangeReport based on the
 * comparison between GenerateConfigReportRequest.new_value and
 * GenerateConfigReportRequest.old_value.
 * If GenerateConfigReportRequest.old_value is not specified, this method
 * will compare GenerateConfigReportRequest.new_value with the last pushed
 * service configuration.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function generate_config_report_sample(): void
{
    // Create a client.
    $serviceManagerClient = new ServiceManagerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $newConfig = new Any();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateConfigReportResponse $response */
        $response = $serviceManagerClient->generateConfigReport($newConfig);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END servicemanagement_v1_generated_ServiceManager_GenerateConfigReport_sync]
