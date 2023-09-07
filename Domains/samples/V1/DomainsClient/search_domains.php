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

// [START domains_v1_generated_Domains_SearchDomains_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Domains\V1\Client\DomainsClient;
use Google\Cloud\Domains\V1\SearchDomainsRequest;
use Google\Cloud\Domains\V1\SearchDomainsResponse;

/**
 * Searches for available domain names similar to the provided query.
 *
 * Availability results from this method are approximate; call
 * `RetrieveRegisterParameters` on a domain before registering to confirm
 * availability.
 *
 * @param string $query             String used to search for available domain names.
 * @param string $formattedLocation The location. Must be in the format `projects/&#42;/locations/*`. Please see
 *                                  {@see DomainsClient::locationName()} for help formatting this field.
 */
function search_domains_sample(string $query, string $formattedLocation): void
{
    // Create a client.
    $domainsClient = new DomainsClient();

    // Prepare the request message.
    $request = (new SearchDomainsRequest())
        ->setQuery($query)
        ->setLocation($formattedLocation);

    // Call the API and handle any network failures.
    try {
        /** @var SearchDomainsResponse $response */
        $response = $domainsClient->searchDomains($request);
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
    $query = '[QUERY]';
    $formattedLocation = DomainsClient::locationName('[PROJECT]', '[LOCATION]');

    search_domains_sample($query, $formattedLocation);
}
// [END domains_v1_generated_Domains_SearchDomains_sync]
