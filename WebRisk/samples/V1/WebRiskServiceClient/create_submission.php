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

// [START webrisk_v1_generated_WebRiskService_CreateSubmission_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\WebRisk\V1\Submission;
use Google\Cloud\WebRisk\V1\WebRiskServiceClient;

/**
 * Creates a Submission of a URI suspected of containing phishing content to
 * be reviewed. If the result verifies the existence of malicious phishing
 * content, the site will be added to the [Google's Social Engineering
 * lists](https://support.google.com/webmasters/answer/6350487/) in order to
 * protect users that could get exposed to this threat in the future. Only
 * allowlisted projects can use this method during Early Access. Please reach
 * out to Sales or your customer engineer to obtain access.
 *
 * @param string $formattedParent The name of the project that is making the submission. This string is in
 *                                the format "projects/{project_number}". Please see
 *                                {@see WebRiskServiceClient::projectName()} for help formatting this field.
 * @param string $submissionUri   The URI that is being reported for malicious content to be analyzed.
 */
function create_submission_sample(string $formattedParent, string $submissionUri): void
{
    // Create a client.
    $webRiskServiceClient = new WebRiskServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $submission = (new Submission())
        ->setUri($submissionUri);

    // Call the API and handle any network failures.
    try {
        /** @var Submission $response */
        $response = $webRiskServiceClient->createSubmission($formattedParent, $submission);
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
    $formattedParent = WebRiskServiceClient::projectName('[PROJECT]');
    $submissionUri = '[URI]';

    create_submission_sample($formattedParent, $submissionUri);
}
// [END webrisk_v1_generated_WebRiskService_CreateSubmission_sync]
