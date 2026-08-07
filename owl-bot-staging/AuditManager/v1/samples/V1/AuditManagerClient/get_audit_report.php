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

// [START auditmanager_v1_generated_AuditManager_GetAuditReport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AuditManager\V1\AuditReport;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\GetAuditReportRequest;

/**
 * Get the overall audit report
 *
 * @param string $formattedName Format
 *                              projects/{project}/locations/{location}/auditReports/{audit_report},
 *                              folders/{folder}/locations/{location}/auditReports/{audit_report}
 *                              Please see {@see AuditManagerClient::auditReportName()} for help formatting this field.
 */
function get_audit_report_sample(string $formattedName): void
{
    // Create a client.
    $auditManagerClient = new AuditManagerClient();

    // Prepare the request message.
    $request = (new GetAuditReportRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AuditReport $response */
        $response = $auditManagerClient->getAuditReport($request);
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
    $formattedName = AuditManagerClient::auditReportName('[PROJECT]', '[LOCATION]', '[AUDIT_REPORT]');

    get_audit_report_sample($formattedName);
}
// [END auditmanager_v1_generated_AuditManager_GetAuditReport_sync]
