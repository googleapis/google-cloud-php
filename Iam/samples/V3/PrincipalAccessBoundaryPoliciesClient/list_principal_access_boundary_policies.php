<?php
/*
 * Copyright 2025 Google LLC
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

// [START iam_v3_generated_PrincipalAccessBoundaryPolicies_ListPrincipalAccessBoundaryPolicies_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Iam\V3\Client\PrincipalAccessBoundaryPoliciesClient;
use Google\Cloud\Iam\V3\ListPrincipalAccessBoundaryPoliciesRequest;
use Google\Cloud\Iam\V3\PrincipalAccessBoundaryPolicy;

/**
 * Lists principal access boundary policies.
 *
 * @param string $formattedParent The parent resource, which owns the collection of principal
 *                                access boundary policies.
 *
 *                                Format:
 *                                `organizations/{organization_id}/locations/{location}`
 *                                Please see {@see PrincipalAccessBoundaryPoliciesClient::organizationLocationName()} for help formatting this field.
 */
function list_principal_access_boundary_policies_sample(string $formattedParent): void
{
    // Create a client.
    $principalAccessBoundaryPoliciesClient = new PrincipalAccessBoundaryPoliciesClient();

    // Prepare the request message.
    $request = (new ListPrincipalAccessBoundaryPoliciesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $principalAccessBoundaryPoliciesClient->listPrincipalAccessBoundaryPolicies($request);

        /** @var PrincipalAccessBoundaryPolicy $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = PrincipalAccessBoundaryPoliciesClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );

    list_principal_access_boundary_policies_sample($formattedParent);
}
// [END iam_v3_generated_PrincipalAccessBoundaryPolicies_ListPrincipalAccessBoundaryPolicies_sync]
