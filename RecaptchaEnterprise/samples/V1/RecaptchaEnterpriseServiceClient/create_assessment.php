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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_CreateAssessment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\CreateAssessmentRequest;

/**
 * Creates an Assessment of the likelihood an event is legitimate.
 *
 * @param string $formattedParent The name of the project in which the assessment will be created,
 *                                in the format `projects/{project}`. Please see
 *                                {@see RecaptchaEnterpriseServiceClient::projectName()} for help formatting this field.
 */
function create_assessment_sample(string $formattedParent): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $assessment = new Assessment();
    $request = (new CreateAssessmentRequest())
        ->setParent($formattedParent)
        ->setAssessment($assessment);

    // Call the API and handle any network failures.
    try {
        /** @var Assessment $response */
        $response = $recaptchaEnterpriseServiceClient->createAssessment($request);
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
    $formattedParent = RecaptchaEnterpriseServiceClient::projectName('[PROJECT]');

    create_assessment_sample($formattedParent);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_CreateAssessment_sync]
