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

// [START backupdr_v1beta_generated_BackupDR_CreateAutoProtectionPolicyBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1beta\AutoProtectionPolicyBinding;
use Google\Cloud\BackupDR\V1beta\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1beta\CreateAutoProtectionPolicyBindingRequest;
use Google\Rpc\Status;

/**
 * Creates a new AutoProtectionPolicyBinding in a given project and
 * location.
 *
 * @param string $formattedParent                  The parent resource where this binding will be created.
 *                                                 Format:
 *                                                 projects/{project}/locations/{location}/autoProtectionPolicies/{auto_protection_policy}
 *                                                 Please see {@see BackupDRClient::autoProtectionPolicyName()} for help formatting this field.
 * @param string $autoProtectionPolicyBindingId    The ID to use for the binding.
 *                                                 This will become the final component of the binding's resource name.
 * @param string $autoProtectionPolicyBindingScope Immutable. Resource Id of target container on which policy will
 *                                                 be applied. Format: projects/{project_id}
 */
function create_auto_protection_policy_binding_sample(
    string $formattedParent,
    string $autoProtectionPolicyBindingId,
    string $autoProtectionPolicyBindingScope
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $autoProtectionPolicyBinding = (new AutoProtectionPolicyBinding())
        ->setScope($autoProtectionPolicyBindingScope);
    $request = (new CreateAutoProtectionPolicyBindingRequest())
        ->setParent($formattedParent)
        ->setAutoProtectionPolicyBindingId($autoProtectionPolicyBindingId)
        ->setAutoProtectionPolicyBinding($autoProtectionPolicyBinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createAutoProtectionPolicyBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AutoProtectionPolicyBinding $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedParent = BackupDRClient::autoProtectionPolicyName(
        '[PROJECT]',
        '[LOCATION]',
        '[AUTO_PROTECTION_POLICY]'
    );
    $autoProtectionPolicyBindingId = '[AUTO_PROTECTION_POLICY_BINDING_ID]';
    $autoProtectionPolicyBindingScope = '[SCOPE]';

    create_auto_protection_policy_binding_sample(
        $formattedParent,
        $autoProtectionPolicyBindingId,
        $autoProtectionPolicyBindingScope
    );
}
// [END backupdr_v1beta_generated_BackupDR_CreateAutoProtectionPolicyBinding_sync]
