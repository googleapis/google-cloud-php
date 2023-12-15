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

// [START orgpolicy_v2_generated_OrgPolicy_DeleteCustomConstraint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OrgPolicy\V2\Client\OrgPolicyClient;
use Google\Cloud\OrgPolicy\V2\DeleteCustomConstraintRequest;

/**
 * Deletes a custom constraint.
 *
 * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
 * constraint does not exist.
 *
 * @param string $formattedName Name of the custom constraint to delete.
 *                              See the custom constraint entry for naming rules. Please see
 *                              {@see OrgPolicyClient::customConstraintName()} for help formatting this field.
 */
function delete_custom_constraint_sample(string $formattedName): void
{
    // Create a client.
    $orgPolicyClient = new OrgPolicyClient();

    // Prepare the request message.
    $request = (new DeleteCustomConstraintRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $orgPolicyClient->deleteCustomConstraint($request);
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
    $formattedName = OrgPolicyClient::customConstraintName('[ORGANIZATION]', '[CUSTOM_CONSTRAINT]');

    delete_custom_constraint_sample($formattedName);
}
// [END orgpolicy_v2_generated_OrgPolicy_DeleteCustomConstraint_sync]
