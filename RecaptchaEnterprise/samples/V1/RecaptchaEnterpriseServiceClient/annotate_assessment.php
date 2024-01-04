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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_AnnotateAssessment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentRequest\Annotation;
use Google\Cloud\RecaptchaEnterprise\V1\AnnotateAssessmentResponse;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;

/**
 * Annotates a previously created Assessment to provide additional information
 * on whether the event turned out to be authentic or fraudulent.
 *
 * @param string $formattedName The resource name of the Assessment, in the format
 *                              `projects/{project}/assessments/{assessment}`. Please see
 *                              {@see RecaptchaEnterpriseServiceClient::assessmentName()} for help formatting this field.
 * @param int    $annotation    Optional. The annotation that will be assigned to the Event. This field can
 *                              be left empty to provide reasons that apply to an event without concluding
 *                              whether the event is legitimate or fraudulent.
 */
function annotate_assessment_sample(string $formattedName, int $annotation): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $request = (new AnnotateAssessmentRequest())
        ->setName($formattedName)
        ->setAnnotation($annotation);

    // Call the API and handle any network failures.
    try {
        /** @var AnnotateAssessmentResponse $response */
        $response = $recaptchaEnterpriseServiceClient->annotateAssessment($request);
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
    $formattedName = RecaptchaEnterpriseServiceClient::assessmentName('[PROJECT]', '[ASSESSMENT]');
    $annotation = Annotation::ANNOTATION_UNSPECIFIED;

    annotate_assessment_sample($formattedName, $annotation);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_AnnotateAssessment_sync]
