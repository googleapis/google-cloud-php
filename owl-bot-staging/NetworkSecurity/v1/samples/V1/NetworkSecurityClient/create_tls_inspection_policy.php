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

// [START networksecurity_v1_generated_NetworkSecurity_CreateTlsInspectionPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\CreateTlsInspectionPolicyRequest;
use Google\Cloud\NetworkSecurity\V1\TlsInspectionPolicy;
use Google\Rpc\Status;

/**
 * Creates a new TlsInspectionPolicy in a given project and location.
 *
 * @param string $formattedParent                    The parent resource of the TlsInspectionPolicy. Must be in the
 *                                                   format `projects/{project}/locations/{location}`. Please see
 *                                                   {@see NetworkSecurityClient::locationName()} for help formatting this field.
 * @param string $tlsInspectionPolicyId              Short name of the TlsInspectionPolicy resource to be created.
 *                                                   This value should be 1-63 characters long, containing only
 *                                                   letters, numbers, hyphens, and underscores, and should not start
 *                                                   with a number. E.g. "tls_inspection_policy1".
 * @param string $tlsInspectionPolicyName            Name of the resource. Name is of the form
 *                                                   projects/{project}/locations/{location}/tlsInspectionPolicies/{tls_inspection_policy}
 *                                                   tls_inspection_policy should match the
 *                                                   pattern:(^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$).
 * @param string $formattedTlsInspectionPolicyCaPool A CA pool resource used to issue interception certificates.
 *                                                   The CA pool string has a relative resource path following the form
 *                                                   "projects/{project}/locations/{location}/caPools/{ca_pool}". Please see
 *                                                   {@see NetworkSecurityClient::caPoolName()} for help formatting this field.
 */
function create_tls_inspection_policy_sample(
    string $formattedParent,
    string $tlsInspectionPolicyId,
    string $tlsInspectionPolicyName,
    string $formattedTlsInspectionPolicyCaPool
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $tlsInspectionPolicy = (new TlsInspectionPolicy())
        ->setName($tlsInspectionPolicyName)
        ->setCaPool($formattedTlsInspectionPolicyCaPool);
    $request = (new CreateTlsInspectionPolicyRequest())
        ->setParent($formattedParent)
        ->setTlsInspectionPolicyId($tlsInspectionPolicyId)
        ->setTlsInspectionPolicy($tlsInspectionPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->createTlsInspectionPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TlsInspectionPolicy $result */
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
    $formattedParent = NetworkSecurityClient::locationName('[PROJECT]', '[LOCATION]');
    $tlsInspectionPolicyId = '[TLS_INSPECTION_POLICY_ID]';
    $tlsInspectionPolicyName = '[NAME]';
    $formattedTlsInspectionPolicyCaPool = NetworkSecurityClient::caPoolName(
        '[PROJECT]',
        '[LOCATION]',
        '[CA_POOL]'
    );

    create_tls_inspection_policy_sample(
        $formattedParent,
        $tlsInspectionPolicyId,
        $tlsInspectionPolicyName,
        $formattedTlsInspectionPolicyCaPool
    );
}
// [END networksecurity_v1_generated_NetworkSecurity_CreateTlsInspectionPolicy_sync]
