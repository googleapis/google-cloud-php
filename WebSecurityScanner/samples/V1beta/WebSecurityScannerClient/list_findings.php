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

// [START websecurityscanner_v1beta_generated_WebSecurityScanner_ListFindings_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\WebSecurityScanner\V1beta\Finding;
use Google\Cloud\WebSecurityScanner\V1beta\WebSecurityScannerClient;

/**
 * List Findings under a given ScanRun.
 *
 * @param string $formattedParent The parent resource name, which should be a scan run resource name in the
 *                                format
 *                                'projects/{projectId}/scanConfigs/{scanConfigId}/scanRuns/{scanRunId}'. Please see
 *                                {@see WebSecurityScannerClient::scanRunName()} for help formatting this field.
 * @param string $filter          The filter expression. The expression must be in the format: <field>
 *                                <operator> <value>.
 *                                Supported field: 'finding_type'.
 *                                Supported operator: '='.
 */
function list_findings_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $webSecurityScannerClient = new WebSecurityScannerClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $webSecurityScannerClient->listFindings($formattedParent, $filter);

        /** @var Finding $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = WebSecurityScannerClient::scanRunName(
        '[PROJECT]',
        '[SCAN_CONFIG]',
        '[SCAN_RUN]'
    );
    $filter = '[FILTER]';

    list_findings_sample($formattedParent, $filter);
}
// [END websecurityscanner_v1beta_generated_WebSecurityScanner_ListFindings_sync]
