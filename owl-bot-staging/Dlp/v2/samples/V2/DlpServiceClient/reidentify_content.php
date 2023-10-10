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

// [START dlp_v2_generated_DlpService_ReidentifyContent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\Cloud\Dlp\V2\ReidentifyContentResponse;

/**
 * Re-identifies content that has been de-identified.
 * See
 * https://cloud.google.com/dlp/docs/pseudonymization#re-identification_in_free_text_code_example
 * to learn more.
 *
 * @param string $formattedParent Parent resource name.
 *
 *                                The format of this value varies depending on whether you have [specified a
 *                                processing
 *                                location](https://cloud.google.com/dlp/docs/specifying-location):
 *
 *                                + Projects scope, location specified:<br/>
 *                                `projects/`<var>PROJECT_ID</var>`/locations/`<var>LOCATION_ID</var>
 *                                + Projects scope, no location specified (defaults to global):<br/>
 *                                `projects/`<var>PROJECT_ID</var>
 *
 *                                The following example `parent` string specifies a parent project with the
 *                                identifier `example-project`, and specifies the `europe-west3` location
 *                                for processing data:
 *
 *                                parent=projects/example-project/locations/europe-west3
 *                                Please see {@see DlpServiceClient::projectName()} for help formatting this field.
 */
function reidentify_content_sample(string $formattedParent): void
{
    // Create a client.
    $dlpServiceClient = new DlpServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ReidentifyContentResponse $response */
        $response = $dlpServiceClient->reidentifyContent($formattedParent);
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
    $formattedParent = DlpServiceClient::projectName('[PROJECT]');

    reidentify_content_sample($formattedParent);
}
// [END dlp_v2_generated_DlpService_ReidentifyContent_sync]
