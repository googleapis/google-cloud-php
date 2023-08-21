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

// [START gkehub_v1beta1_generated_GkeHubMembershipService_GenerateExclusivityManifest_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeHub\V1beta1\GenerateExclusivityManifestResponse;
use Google\Cloud\GkeHub\V1beta1\GkeHubMembershipServiceClient;

/**
 * GenerateExclusivityManifest generates the manifests to update the
 * exclusivity artifacts in the cluster if needed.
 *
 * Exclusivity artifacts include the Membership custom resource definition
 * (CRD) and the singleton Membership custom resource (CR). Combined with
 * ValidateExclusivity, exclusivity artifacts guarantee that a Kubernetes
 * cluster is only registered to a single GKE Hub.
 *
 * The Membership CRD is versioned, and may require conversion when the GKE
 * Hub API server begins serving a newer version of the CRD and
 * corresponding CR. The response will be the converted CRD and CR if there
 * are any differences between the versions.
 *
 * @param string $formattedName The Membership resource name in the format
 *                              `projects/&#42;/locations/&#42;/memberships/*`. Please see
 *                              {@see GkeHubMembershipServiceClient::membershipName()} for help formatting this field.
 */
function generate_exclusivity_manifest_sample(string $formattedName): void
{
    // Create a client.
    $gkeHubMembershipServiceClient = new GkeHubMembershipServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateExclusivityManifestResponse $response */
        $response = $gkeHubMembershipServiceClient->generateExclusivityManifest($formattedName);
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
    $formattedName = GkeHubMembershipServiceClient::membershipName(
        '[PROJECT]',
        '[LOCATION]',
        '[MEMBERSHIP]'
    );

    generate_exclusivity_manifest_sample($formattedName);
}
// [END gkehub_v1beta1_generated_GkeHubMembershipService_GenerateExclusivityManifest_sync]
