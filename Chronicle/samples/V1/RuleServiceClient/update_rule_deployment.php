<?php
/*
 * Copyright 2025 Google LLC
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

// [START chronicle_v1_generated_RuleService_UpdateRuleDeployment_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\RuleServiceClient;
use Google\Cloud\Chronicle\V1\RuleDeployment;
use Google\Cloud\Chronicle\V1\UpdateRuleDeploymentRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a RuleDeployment.
 * Failures are not necessarily atomic. If there is a request to update
 * multiple fields, and any update to a single field fails, an error will be
 * returned, but other fields may remain successfully updated.
 *
 * @param string $ruleDeploymentName The resource name of the rule deployment.
 *                                   Note that RuleDeployment is a child of the overall Rule, not any individual
 *                                   revision, so the resource ID segment for the Rule resource must not
 *                                   reference a specific revision.
 *                                   Format:
 *                                   `projects/{project}/locations/{location}/instances/{instance}/rules/{rule}/deployment`
 */
function update_rule_deployment_sample(string $ruleDeploymentName): void
{
    // Create a client.
    $ruleServiceClient = new RuleServiceClient();

    // Prepare the request message.
    $ruleDeployment = (new RuleDeployment())
        ->setName($ruleDeploymentName);
    $updateMask = new FieldMask();
    $request = (new UpdateRuleDeploymentRequest())
        ->setRuleDeployment($ruleDeployment)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var RuleDeployment $response */
        $response = $ruleServiceClient->updateRuleDeployment($request);
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
    $ruleDeploymentName = '[NAME]';

    update_rule_deployment_sample($ruleDeploymentName);
}
// [END chronicle_v1_generated_RuleService_UpdateRuleDeployment_sync]
