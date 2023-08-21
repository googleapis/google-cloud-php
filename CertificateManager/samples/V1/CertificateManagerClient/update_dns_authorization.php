<?php
/*
 * Copyright 2022 Google LLC
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

// [START certificatemanager_v1_generated_CertificateManager_UpdateDnsAuthorization_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CertificateManager\V1\Client\CertificateManagerClient;
use Google\Cloud\CertificateManager\V1\DnsAuthorization;
use Google\Cloud\CertificateManager\V1\UpdateDnsAuthorizationRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a DnsAuthorization.
 *
 * @param string $dnsAuthorizationDomain Immutable. A domain that is being authorized. A DnsAuthorization
 *                                       resource covers a single domain and its wildcard, e.g. authorization for
 *                                       `example.com` can be used to issue certificates for `example.com` and
 *                                       `*.example.com`.
 */
function update_dns_authorization_sample(string $dnsAuthorizationDomain): void
{
    // Create a client.
    $certificateManagerClient = new CertificateManagerClient();

    // Prepare the request message.
    $dnsAuthorization = (new DnsAuthorization())
        ->setDomain($dnsAuthorizationDomain);
    $updateMask = new FieldMask();
    $request = (new UpdateDnsAuthorizationRequest())
        ->setDnsAuthorization($dnsAuthorization)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateManagerClient->updateDnsAuthorization($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DnsAuthorization $result */
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
    $dnsAuthorizationDomain = '[DOMAIN]';

    update_dns_authorization_sample($dnsAuthorizationDomain);
}
// [END certificatemanager_v1_generated_CertificateManager_UpdateDnsAuthorization_sync]
