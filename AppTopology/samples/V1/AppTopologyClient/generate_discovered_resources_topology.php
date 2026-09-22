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

// [START apptopology_v1_generated_AppTopology_GenerateDiscoveredResourcesTopology_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppTopology\V1\Client\AppTopologyClient;
use Google\Cloud\AppTopology\V1\GenerateDiscoveredResourcesTopologyRequest;
use Google\Cloud\AppTopology\V1\GenerateDiscoveredResourcesTopologyResponse;

/**
 * Generate the topology for all resources in the given project. If the
 * project represents an
 * [app
 * boundary](https://cloud.google.com/app-hub/docs/reference/rest/v1/Boundary),
 * the topology is generated for all resources in the boundary.
 *
 * @param string $formattedName                   The project to query discoverable resources on.
 *                                                Expected format:
 *                                                `projects/{project}/locations/{location}/discoveredResourcesTopology`.
 *                                                Only `global` location is supported. Please see
 *                                                {@see AppTopologyClient::discoveredResourcesTopologyName()} for help formatting this field.
 * @param string $formattedTopologyDomainsElement The full resource name of the domain of the app topology.
 *                                                Format: `projects/{project}/locations/{location}/domains/{domain}`
 *                                                Caller must have apptopology.domains.get permission on each of the domains. Please see
 *                                                {@see AppTopologyClient::domainName()} for help formatting this field.
 */
function generate_discovered_resources_topology_sample(
    string $formattedName,
    string $formattedTopologyDomainsElement
): void {
    // Create a client.
    $appTopologyClient = new AppTopologyClient();

    // Prepare the request message.
    $formattedTopologyDomains = [$formattedTopologyDomainsElement,];
    $request = (new GenerateDiscoveredResourcesTopologyRequest())
        ->setName($formattedName)
        ->setTopologyDomains($formattedTopologyDomains);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateDiscoveredResourcesTopologyResponse $response */
        $response = $appTopologyClient->generateDiscoveredResourcesTopology($request);
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
    $formattedName = AppTopologyClient::discoveredResourcesTopologyName('[PROJECT]', '[LOCATION]');
    $formattedTopologyDomainsElement = AppTopologyClient::domainName(
        '[PROJECT]',
        '[LOCATION]',
        '[DOMAIN]'
    );

    generate_discovered_resources_topology_sample($formattedName, $formattedTopologyDomainsElement);
}
// [END apptopology_v1_generated_AppTopology_GenerateDiscoveredResourcesTopology_sync]
