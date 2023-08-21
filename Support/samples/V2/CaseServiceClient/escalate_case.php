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

// [START cloudsupport_v2_generated_CaseService_EscalateCase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\CaseServiceClient;
use Google\Cloud\Support\V2\EscalateCaseRequest;
use Google\Cloud\Support\V2\PBCase;

/**
 * Escalate a case. Escalating a case will initiate the Google Cloud Support
 * escalation management process.
 *
 * This operation is only available to certain Customer Care tiers. Go to
 * https://cloud.google.com/support and look for 'Technical support
 * escalations' in the feature list to find out which tiers are able to
 * perform escalations.
 *
 * @param string $formattedName The fully qualified name of the Case resource to be escalated. Please see
 *                              {@see CaseServiceClient::caseName()} for help formatting this field.
 */
function escalate_case_sample(string $formattedName): void
{
    // Create a client.
    $caseServiceClient = new CaseServiceClient();

    // Prepare the request message.
    $request = (new EscalateCaseRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PBCase $response */
        $response = $caseServiceClient->escalateCase($request);
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
    $formattedName = CaseServiceClient::caseName('[ORGANIZATION]', '[CASE]');

    escalate_case_sample($formattedName);
}
// [END cloudsupport_v2_generated_CaseService_EscalateCase_sync]
