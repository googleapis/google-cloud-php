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

// [START binaryauthorization_v1_generated_BinauthzManagementServiceV1_UpdatePolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule;
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule\EnforcementMode;
use Google\Cloud\BinaryAuthorization\V1\AdmissionRule\EvaluationMode;
use Google\Cloud\BinaryAuthorization\V1\Client\BinauthzManagementServiceV1Client;
use Google\Cloud\BinaryAuthorization\V1\Policy;
use Google\Cloud\BinaryAuthorization\V1\UpdatePolicyRequest;

/**
 * Creates or updates a project's [policy][google.cloud.binaryauthorization.v1.Policy], and returns a copy of the
 * new [policy][google.cloud.binaryauthorization.v1.Policy]. A policy is always updated as a whole, to avoid race
 * conditions with concurrent policy enforcement (or management!)
 * requests. Returns NOT_FOUND if the project does not exist, INVALID_ARGUMENT
 * if the request is malformed.
 *
 * @param int $policyDefaultAdmissionRuleEvaluationMode  How this admission rule will be evaluated.
 * @param int $policyDefaultAdmissionRuleEnforcementMode The action when a pod creation is denied by the admission rule.
 */
function update_policy_sample(
    int $policyDefaultAdmissionRuleEvaluationMode,
    int $policyDefaultAdmissionRuleEnforcementMode
): void {
    // Create a client.
    $binauthzManagementServiceV1Client = new BinauthzManagementServiceV1Client();

    // Prepare the request message.
    $policyDefaultAdmissionRule = (new AdmissionRule())
        ->setEvaluationMode($policyDefaultAdmissionRuleEvaluationMode)
        ->setEnforcementMode($policyDefaultAdmissionRuleEnforcementMode);
    $policy = (new Policy())
        ->setDefaultAdmissionRule($policyDefaultAdmissionRule);
    $request = (new UpdatePolicyRequest())
        ->setPolicy($policy);

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $binauthzManagementServiceV1Client->updatePolicy($request);
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
    $policyDefaultAdmissionRuleEvaluationMode = EvaluationMode::EVALUATION_MODE_UNSPECIFIED;
    $policyDefaultAdmissionRuleEnforcementMode = EnforcementMode::ENFORCEMENT_MODE_UNSPECIFIED;

    update_policy_sample(
        $policyDefaultAdmissionRuleEvaluationMode,
        $policyDefaultAdmissionRuleEnforcementMode
    );
}
// [END binaryauthorization_v1_generated_BinauthzManagementServiceV1_UpdatePolicy_sync]
