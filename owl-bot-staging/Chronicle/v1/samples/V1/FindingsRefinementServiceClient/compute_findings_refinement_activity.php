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

// [START chronicle_v1_generated_FindingsRefinementService_ComputeFindingsRefinementActivity_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\FindingsRefinementServiceClient;
use Google\Cloud\Chronicle\V1\ComputeFindingsRefinementActivityRequest;
use Google\Cloud\Chronicle\V1\ComputeFindingsRefinementActivityResponse;

/**
 * Returns findings refinement activity for a specific findings refinement.
 *
 * @param string $formattedName Full resource name for the findings refinement to fetch the
 *                              activity for. Format:
 *                              projects/{project}/locations/{region}/instances/{instance}/findingsRefinements/{findings_refinement}
 *                              Please see {@see FindingsRefinementServiceClient::findingsRefinementName()} for help formatting this field.
 */
function compute_findings_refinement_activity_sample(string $formattedName): void
{
    // Create a client.
    $findingsRefinementServiceClient = new FindingsRefinementServiceClient();

    // Prepare the request message.
    $request = (new ComputeFindingsRefinementActivityRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ComputeFindingsRefinementActivityResponse $response */
        $response = $findingsRefinementServiceClient->computeFindingsRefinementActivity($request);
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
    $formattedName = FindingsRefinementServiceClient::findingsRefinementName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[FINDINGS_REFINEMENT]'
    );

    compute_findings_refinement_activity_sample($formattedName);
}
// [END chronicle_v1_generated_FindingsRefinementService_ComputeFindingsRefinementActivity_sync]
