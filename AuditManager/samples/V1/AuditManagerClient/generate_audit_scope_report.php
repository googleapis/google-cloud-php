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

// [START auditmanager_v1_generated_AuditManager_GenerateAuditScopeReport_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AuditManager\V1\AuditScopeReport;
use Google\Cloud\AuditManager\V1\Client\AuditManagerClient;
use Google\Cloud\AuditManager\V1\GenerateAuditScopeReportRequest;
use Google\Cloud\AuditManager\V1\GenerateAuditScopeReportRequest\AuditScopeReportFormat;

/**
 * Generates an audit scope report for the given standard.
 *
 * The report includes the following:
 *
 * * The technical attributes and constraints that Audit Manager uses to
 * verify your compliance with a framework.
 * * A list of Google Cloud services and resources that are within the
 * scope of the framework.
 *
 * @param string $scope               Project or folder that the audit scope report is generated for,
 *                                    in one of the following formats:
 *
 *                                    * `projects/{project}/locations/{location}`
 *                                    * `folders/{folder}/locations/{location}`
 *                                    * `organizations/{organization}/locations/{location}`
 * @param int    $reportFormat        Format for the audit scope report.
 * @param string $complianceFramework Framework (set of controls) that the audit scope report is
 *                                    generated against. For example, `NIST_800_53`.
 */
function generate_audit_scope_report_sample(
    string $scope,
    int $reportFormat,
    string $complianceFramework
): void {
    // Create a client.
    $auditManagerClient = new AuditManagerClient();

    // Prepare the request message.
    $request = (new GenerateAuditScopeReportRequest())
        ->setScope($scope)
        ->setReportFormat($reportFormat)
        ->setComplianceFramework($complianceFramework);

    // Call the API and handle any network failures.
    try {
        /** @var AuditScopeReport $response */
        $response = $auditManagerClient->generateAuditScopeReport($request);
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
    $scope = '[SCOPE]';
    $reportFormat = AuditScopeReportFormat::AUDIT_SCOPE_REPORT_FORMAT_UNSPECIFIED;
    $complianceFramework = '[COMPLIANCE_FRAMEWORK]';

    generate_audit_scope_report_sample($scope, $reportFormat, $complianceFramework);
}
// [END auditmanager_v1_generated_AuditManager_GenerateAuditScopeReport_sync]
