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

// [START domains_v1_generated_Domains_RetrieveTransferParameters_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Domains\V1\Client\DomainsClient;
use Google\Cloud\Domains\V1\RetrieveTransferParametersRequest;
use Google\Cloud\Domains\V1\RetrieveTransferParametersResponse;

/**
 * Gets parameters needed to transfer a domain name from another registrar to
 * Cloud Domains. For domains managed by Google Domains, transferring to Cloud
 * Domains is not supported.
 *
 *
 * Use the returned values to call `TransferDomain`.
 *
 * @param string $domainName        The domain name. Unicode domain names must be expressed in Punycode format.
 * @param string $formattedLocation The location. Must be in the format `projects/&#42;/locations/*`. Please see
 *                                  {@see DomainsClient::locationName()} for help formatting this field.
 */
function retrieve_transfer_parameters_sample(string $domainName, string $formattedLocation): void
{
    // Create a client.
    $domainsClient = new DomainsClient();

    // Prepare the request message.
    $request = (new RetrieveTransferParametersRequest())
        ->setDomainName($domainName)
        ->setLocation($formattedLocation);

    // Call the API and handle any network failures.
    try {
        /** @var RetrieveTransferParametersResponse $response */
        $response = $domainsClient->retrieveTransferParameters($request);
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
    $domainName = '[DOMAIN_NAME]';
    $formattedLocation = DomainsClient::locationName('[PROJECT]', '[LOCATION]');

    retrieve_transfer_parameters_sample($domainName, $formattedLocation);
}
// [END domains_v1_generated_Domains_RetrieveTransferParameters_sync]
