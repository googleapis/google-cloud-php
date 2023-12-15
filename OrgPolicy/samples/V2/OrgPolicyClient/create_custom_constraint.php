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

// [START orgpolicy_v2_generated_OrgPolicy_CreateCustomConstraint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OrgPolicy\V2\Client\OrgPolicyClient;
use Google\Cloud\OrgPolicy\V2\CreateCustomConstraintRequest;
use Google\Cloud\OrgPolicy\V2\CustomConstraint;

/**
 * Creates a custom constraint.
 *
 * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
 * organization does not exist.
 * Returns a `google.rpc.Status` with `google.rpc.Code.ALREADY_EXISTS` if the
 * constraint already exists on the given organization.
 *
 * @param string $formattedParent Must be in the following form:
 *
 *                                * `organizations/{organization_id}`
 *                                Please see {@see OrgPolicyClient::organizationName()} for help formatting this field.
 */
function create_custom_constraint_sample(string $formattedParent): void
{
    // Create a client.
    $orgPolicyClient = new OrgPolicyClient();

    // Prepare the request message.
    $customConstraint = new CustomConstraint();
    $request = (new CreateCustomConstraintRequest())
        ->setParent($formattedParent)
        ->setCustomConstraint($customConstraint);

    // Call the API and handle any network failures.
    try {
        /** @var CustomConstraint $response */
        $response = $orgPolicyClient->createCustomConstraint($request);
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
    $formattedParent = OrgPolicyClient::organizationName('[ORGANIZATION]');

    create_custom_constraint_sample($formattedParent);
}
// [END orgpolicy_v2_generated_OrgPolicy_CreateCustomConstraint_sync]
