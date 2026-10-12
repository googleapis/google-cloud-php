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

// [START dataform_v1beta1_generated_Dataform_CheckoutWorkspaceBranch_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataform\V1beta1\CheckoutWorkspaceBranchRequest;
use Google\Cloud\Dataform\V1beta1\Client\DataformClient;

/**
 * Checkout a branch in a Workspace.
 *
 * @param string $formattedName The workspace resource name.
 *                              Format:
 *                              projects/{project}/locations/{location}/repositories/{repository}/workspaces/{workspace}
 *                              Please see {@see DataformClient::workspaceName()} for help formatting this field.
 * @param string $branch        The name of the branch in the Git repository to which the
 *                              workspace should be checked out.
 */
function checkout_workspace_branch_sample(string $formattedName, string $branch): void
{
    // Create a client.
    $dataformClient = new DataformClient();

    // Prepare the request message.
    $request = (new CheckoutWorkspaceBranchRequest())
        ->setName($formattedName)
        ->setBranch($branch);

    // Call the API and handle any network failures.
    try {
        $dataformClient->checkoutWorkspaceBranch($request);
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
    $formattedName = DataformClient::workspaceName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[WORKSPACE]'
    );
    $branch = '[BRANCH]';

    checkout_workspace_branch_sample($formattedName, $branch);
}
// [END dataform_v1beta1_generated_Dataform_CheckoutWorkspaceBranch_sync]
