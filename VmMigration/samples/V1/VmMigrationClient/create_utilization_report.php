<?php
/*
 * Copyright 2022 Google LLC
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

// [START vmmigration_v1_generated_VmMigration_CreateUtilizationReport_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VMMigration\V1\UtilizationReport;
use Google\Cloud\VMMigration\V1\VmMigrationClient;
use Google\Rpc\Status;

/**
 * Creates a new UtilizationReport.
 *
 * @param string $formattedParent     The Utilization Report's parent. Please see
 *                                    {@see VmMigrationClient::sourceName()} for help formatting this field.
 * @param string $utilizationReportId The ID to use for the report, which will become the final
 *                                    component of the reports's resource name.
 *
 *                                    This value maximum length is 63 characters, and valid characters
 *                                    are /[a-z][0-9]-/. It must start with an english letter and must not
 *                                    end with a hyphen.
 */
function create_utilization_report_sample(
    string $formattedParent,
    string $utilizationReportId
): void {
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $utilizationReport = new UtilizationReport();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmMigrationClient->createUtilizationReport(
            $formattedParent,
            $utilizationReport,
            $utilizationReportId
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var UtilizationReport $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = VmMigrationClient::sourceName('[PROJECT]', '[LOCATION]', '[SOURCE]');
    $utilizationReportId = '[UTILIZATION_REPORT_ID]';

    create_utilization_report_sample($formattedParent, $utilizationReportId);
}
// [END vmmigration_v1_generated_VmMigration_CreateUtilizationReport_sync]
