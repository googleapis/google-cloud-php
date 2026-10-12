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

// [START cloudkms_v1_generated_HsmManagement_CreateSingleTenantHsmInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Kms\V1\Client\HsmManagementClient;
use Google\Cloud\Kms\V1\CreateSingleTenantHsmInstanceRequest;
use Google\Cloud\Kms\V1\SingleTenantHsmInstance;
use Google\Cloud\Kms\V1\SingleTenantHsmInstance\QuorumAuth;
use Google\Rpc\Status;

/**
 * Creates a new
 * [SingleTenantHsmInstance][google.cloud.kms.v1.SingleTenantHsmInstance] in a
 * given Project and Location. User must create a RegisterTwoFactorAuthKeys
 * proposal with this single-tenant HSM instance to finish setup of the
 * instance.
 *
 * @param string $formattedParent                                     The resource name of the location associated with the
 *                                                                    [SingleTenantHsmInstance][google.cloud.kms.v1.SingleTenantHsmInstance], in
 *                                                                    the format `projects/&#42;/locations/*`. Please see
 *                                                                    {@see HsmManagementClient::locationName()} for help formatting this field.
 * @param int    $singleTenantHsmInstanceQuorumAuthTotalApproverCount The total number of approvers. This is the N value used
 *                                                                    for M of N quorum auth. Must be greater than or equal to 3 and less than
 *                                                                    or equal to 16.
 */
function create_single_tenant_hsm_instance_sample(
    string $formattedParent,
    int $singleTenantHsmInstanceQuorumAuthTotalApproverCount
): void {
    // Create a client.
    $hsmManagementClient = new HsmManagementClient();

    // Prepare the request message.
    $singleTenantHsmInstanceQuorumAuth = (new QuorumAuth())
        ->setTotalApproverCount($singleTenantHsmInstanceQuorumAuthTotalApproverCount);
    $singleTenantHsmInstance = (new SingleTenantHsmInstance())
        ->setQuorumAuth($singleTenantHsmInstanceQuorumAuth);
    $request = (new CreateSingleTenantHsmInstanceRequest())
        ->setParent($formattedParent)
        ->setSingleTenantHsmInstance($singleTenantHsmInstance);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $hsmManagementClient->createSingleTenantHsmInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SingleTenantHsmInstance $result */
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
    $formattedParent = HsmManagementClient::locationName('[PROJECT]', '[LOCATION]');
    $singleTenantHsmInstanceQuorumAuthTotalApproverCount = 0;

    create_single_tenant_hsm_instance_sample(
        $formattedParent,
        $singleTenantHsmInstanceQuorumAuthTotalApproverCount
    );
}
// [END cloudkms_v1_generated_HsmManagement_CreateSingleTenantHsmInstance_sync]
