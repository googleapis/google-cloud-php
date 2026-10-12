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

// [START cloudkms_v1_generated_HsmManagement_GetSingleTenantHsmInstanceProposal_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\HsmManagementClient;
use Google\Cloud\Kms\V1\GetSingleTenantHsmInstanceProposalRequest;
use Google\Cloud\Kms\V1\SingleTenantHsmInstanceProposal;

/**
 * Returns metadata for a given
 * [SingleTenantHsmInstanceProposal][google.cloud.kms.v1.SingleTenantHsmInstanceProposal].
 *
 * @param string $formattedName The
 *                              [name][google.cloud.kms.v1.SingleTenantHsmInstanceProposal.name] of the
 *                              [SingleTenantHsmInstanceProposal][google.cloud.kms.v1.SingleTenantHsmInstanceProposal]
 *                              to get. Please see
 *                              {@see HsmManagementClient::singleTenantHsmInstanceProposalName()} for help formatting this field.
 */
function get_single_tenant_hsm_instance_proposal_sample(string $formattedName): void
{
    // Create a client.
    $hsmManagementClient = new HsmManagementClient();

    // Prepare the request message.
    $request = (new GetSingleTenantHsmInstanceProposalRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SingleTenantHsmInstanceProposal $response */
        $response = $hsmManagementClient->getSingleTenantHsmInstanceProposal($request);
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
    $formattedName = HsmManagementClient::singleTenantHsmInstanceProposalName(
        '[PROJECT]',
        '[LOCATION]',
        '[SINGLE_TENANT_HSM_INSTANCE]',
        '[PROPOSAL]'
    );

    get_single_tenant_hsm_instance_proposal_sample($formattedName);
}
// [END cloudkms_v1_generated_HsmManagement_GetSingleTenantHsmInstanceProposal_sync]
