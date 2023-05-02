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

// [START managedidentities_v1_generated_ManagedIdentitiesService_CreateMicrosoftAdDomain_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedIdentities\V1\Domain;
use Google\Cloud\ManagedIdentities\V1\ManagedIdentitiesServiceClient;
use Google\Rpc\Status;

/**
 * Creates a Microsoft AD domain.
 *
 * @param string $formattedParent        The resource project name and location using the form:
 *                                       `projects/{project_id}/locations/global`
 *                                       Please see {@see ManagedIdentitiesServiceClient::locationName()} for help formatting this field.
 * @param string $domainName             The fully qualified domain name.
 *                                       e.g. mydomain.myorganization.com, with the following restrictions:
 *
 *                                       * Must contain only lowercase letters, numbers, periods and hyphens.
 *                                       * Must start with a letter.
 *                                       * Must contain between 2-64 characters.
 *                                       * Must end with a number or a letter.
 *                                       * Must not start with period.
 *                                       * First segement length (mydomain form example above) shouldn't exceed
 *                                       15 chars.
 *                                       * The last segment cannot be fully numeric.
 *                                       * Must be unique within the customer project.
 * @param string $domainName             The unique name of the domain using the form:
 *                                       `projects/{project_id}/locations/global/domains/{domain_name}`.
 * @param string $domainReservedIpRange  The CIDR range of internal addresses that are reserved for this
 *                                       domain. Reserved networks must be /24 or larger. Ranges must be
 *                                       unique and non-overlapping with existing subnets in
 *                                       [Domain].[authorized_networks].
 * @param string $domainLocationsElement Locations where domain needs to be provisioned.
 *                                       [regions][compute/docs/regions-zones/]
 *                                       e.g. us-west1 or us-east4
 *                                       Service supports up to 4 locations at once. Each location will use a /26
 *                                       block.
 */
function create_microsoft_ad_domain_sample(
    string $formattedParent,
    string $domainName,
    string $domainName,
    string $domainReservedIpRange,
    string $domainLocationsElement
): void {
    // Create a client.
    $managedIdentitiesServiceClient = new ManagedIdentitiesServiceClient();

    // Prepare the request message.
    $domainLocations = [$domainLocationsElement,];
    $domain = (new Domain())
        ->setName($domainName)
        ->setReservedIpRange($domainReservedIpRange)
        ->setLocations($domainLocations);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedIdentitiesServiceClient->createMicrosoftAdDomain(
            $formattedParent,
            $domainName,
            $domain
        );
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
    $formattedParent = ManagedIdentitiesServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $domainName = '[DOMAIN_NAME]';
    $domainName = '[NAME]';
    $domainReservedIpRange = '[RESERVED_IP_RANGE]';
    $domainLocationsElement = '[LOCATIONS]';

    create_microsoft_ad_domain_sample(
        $formattedParent,
        $domainName,
        $domainName,
        $domainReservedIpRange,
        $domainLocationsElement
    );
}
// [END managedidentities_v1_generated_ManagedIdentitiesService_CreateMicrosoftAdDomain_sync]
