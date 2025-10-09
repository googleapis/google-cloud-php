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

// [START apihub_v1_generated_LintingService_LintSpec_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\LintingServiceClient;
use Google\Cloud\ApiHub\V1\LintSpecRequest;

/**
 * Lints the requested spec and updates the corresponding API Spec with the
 * lint response. This lint response will be available in all subsequent
 * Get and List Spec calls to Core service.
 *
 * @param string $formattedName The name of the spec to be linted.
 *                              Format:
 *                              `projects/{project}/locations/{location}/apis/{api}/versions/{version}/specs/{spec}`
 *                              Please see {@see LintingServiceClient::specName()} for help formatting this field.
 */
function lint_spec_sample(string $formattedName): void
{
    // Create a client.
    $lintingServiceClient = new LintingServiceClient();

    // Prepare the request message.
    $request = (new LintSpecRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $lintingServiceClient->lintSpec($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = LintingServiceClient::specName(
        '[PROJECT]',
        '[LOCATION]',
        '[API]',
        '[VERSION]',
        '[SPEC]'
    );

    lint_spec_sample($formattedName);
}
// [END apihub_v1_generated_LintingService_LintSpec_sync]
