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

// [START managedidentities_v1_generated_ManagedIdentitiesService_AttachTrust_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedIdentities\V1\Domain;
use Google\Cloud\ManagedIdentities\V1\ManagedIdentitiesServiceClient;
use Google\Cloud\ManagedIdentities\V1\Trust;
use Google\Cloud\ManagedIdentities\V1\Trust\TrustDirection;
use Google\Cloud\ManagedIdentities\V1\Trust\TrustType;
use Google\Rpc\Status;

/**
 * Adds an AD trust to a domain.
 *
 * @param string $formattedName                    The resource domain name, project name and location using the form:
 *                                                 `projects/{project_id}/locations/global/domains/{domain_name}`
 *                                                 Please see {@see ManagedIdentitiesServiceClient::domainName()} for help formatting this field.
 * @param string $trustTargetDomainName            The fully qualified target domain name which will be in trust with the
 *                                                 current domain.
 * @param int    $trustTrustType                   The type of trust represented by the trust resource.
 * @param int    $trustTrustDirection              The trust direction, which decides if the current domain is trusted,
 *                                                 trusting, or both.
 * @param string $trustTargetDnsIpAddressesElement The target DNS server IP addresses which can resolve the remote domain
 *                                                 involved in the trust.
 * @param string $trustTrustHandshakeSecret        The trust secret used for the handshake with the target domain. This will
 *                                                 not be stored.
 */
function attach_trust_sample(
    string $formattedName,
    string $trustTargetDomainName,
    int $trustTrustType,
    int $trustTrustDirection,
    string $trustTargetDnsIpAddressesElement,
    string $trustTrustHandshakeSecret
): void {
    // Create a client.
    $managedIdentitiesServiceClient = new ManagedIdentitiesServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $trustTargetDnsIpAddresses = [$trustTargetDnsIpAddressesElement,];
    $trust = (new Trust())
        ->setTargetDomainName($trustTargetDomainName)
        ->setTrustType($trustTrustType)
        ->setTrustDirection($trustTrustDirection)
        ->setTargetDnsIpAddresses($trustTargetDnsIpAddresses)
        ->setTrustHandshakeSecret($trustTrustHandshakeSecret);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedIdentitiesServiceClient->attachTrust($formattedName, $trust);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Domain $result */
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
    $formattedName = ManagedIdentitiesServiceClient::domainName('[PROJECT]', '[LOCATION]', '[DOMAIN]');
    $trustTargetDomainName = '[TARGET_DOMAIN_NAME]';
    $trustTrustType = TrustType::TRUST_TYPE_UNSPECIFIED;
    $trustTrustDirection = TrustDirection::TRUST_DIRECTION_UNSPECIFIED;
    $trustTargetDnsIpAddressesElement = '[TARGET_DNS_IP_ADDRESSES]';
    $trustTrustHandshakeSecret = '[TRUST_HANDSHAKE_SECRET]';

    attach_trust_sample(
        $formattedName,
        $trustTargetDomainName,
        $trustTrustType,
        $trustTrustDirection,
        $trustTargetDnsIpAddressesElement,
        $trustTrustHandshakeSecret
    );
}
// [END managedidentities_v1_generated_ManagedIdentitiesService_AttachTrust_sync]
