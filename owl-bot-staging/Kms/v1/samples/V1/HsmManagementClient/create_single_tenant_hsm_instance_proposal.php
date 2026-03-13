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

// [START cloudkms_v1_generated_HsmManagement_CreateSingleTenantHsmInstanceProposal_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Kms\V1\Client\HsmManagementClient;
use Google\Cloud\Kms\V1\CreateSingleTenantHsmInstanceProposalRequest;
use Google\Cloud\Kms\V1\SingleTenantHsmInstanceProposal;
use Google\Rpc\Status;

/**
 * Creates a new
 * [SingleTenantHsmInstanceProposal][google.cloud.kms.v1.SingleTenantHsmInstanceProposal]
 * for a given
 * [SingleTenantHsmInstance][google.cloud.kms.v1.SingleTenantHsmInstance].
 *
 * @param string $formattedParent The [name][google.cloud.kms.v1.SingleTenantHsmInstance.name] of
 *                                the [SingleTenantHsmInstance][google.cloud.kms.v1.SingleTenantHsmInstance]
 *                                associated with the
 *                                [SingleTenantHsmInstanceProposals][google.cloud.kms.v1.SingleTenantHsmInstanceProposal]. Please see
 *                                {@see HsmManagementClient::singleTenantHsmInstanceName()} for help formatting this field.
 */
function create_single_tenant_hsm_instance_proposal_sample(string $formattedParent): void
{
    // Create a client.
    $hsmManagementClient = new HsmManagementClient();

    // Prepare the request message.
    $singleTenantHsmInstanceProposal = new SingleTenantHsmInstanceProposal();
    $request = (new CreateSingleTenantHsmInstanceProposalRequest())
        ->setParent($formattedParent)
        ->setSingleTenantHsmInstanceProposal($singleTenantHsmInstanceProposal);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $hsmManagementClient->createSingleTenantHsmInstanceProposal($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SingleTenantHsmInstanceProposal $result */
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
    $formattedParent = HsmManagementClient::singleTenantHsmInstanceName(
        '[PROJECT]',
        '[LOCATION]',
        '[SINGLE_TENANT_HSM_INSTANCE]'
    );

    create_single_tenant_hsm_instance_proposal_sample($formattedParent);
}
// [END cloudkms_v1_generated_HsmManagement_CreateSingleTenantHsmInstanceProposal_sync]
