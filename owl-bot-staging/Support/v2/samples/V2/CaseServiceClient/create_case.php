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

// [START cloudsupport_v2_generated_CaseService_CreateCase_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Support\V2\Client\CaseServiceClient;
use Google\Cloud\Support\V2\CreateCaseRequest;
use Google\Cloud\Support\V2\PBCase;

/**
 * Create a new case and associate it with the given Google Cloud Resource.
 * The case object must have the following fields set: `display_name`,
 * `description`, `classification`, and `priority`.
 *
 * @param string $formattedParent The name of the Google Cloud Resource under which the case should
 *                                be created. Please see
 *                                {@see CaseServiceClient::projectName()} for help formatting this field.
 */
function create_case_sample(string $formattedParent): void
{
    // Create a client.
    $caseServiceClient = new CaseServiceClient();

    // Prepare the request message.
    $case = new PBCase();
    $request = (new CreateCaseRequest())
        ->setParent($formattedParent)
        ->setCase($case);

    // Call the API and handle any network failures.
    try {
        /** @var PBCase $response */
        $response = $caseServiceClient->createCase($request);
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
    $formattedParent = CaseServiceClient::projectName('[PROJECT]');

    create_case_sample($formattedParent);
}
// [END cloudsupport_v2_generated_CaseService_CreateCase_sync]
