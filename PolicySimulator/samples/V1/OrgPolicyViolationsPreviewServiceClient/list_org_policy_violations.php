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

// [START policysimulator_v1_generated_OrgPolicyViolationsPreviewService_ListOrgPolicyViolations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\PolicySimulator\V1\Client\OrgPolicyViolationsPreviewServiceClient;
use Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsRequest;
use Google\Cloud\PolicySimulator\V1\OrgPolicyViolation;

/**
 * ListOrgPolicyViolations lists the [OrgPolicyViolations][] that are present
 * in an
 * [OrgPolicyViolationsPreview][google.cloud.policysimulator.v1.OrgPolicyViolationsPreview].
 *
 * @param string $formattedParent The OrgPolicyViolationsPreview to get OrgPolicyViolations from.
 *                                Format:
 *                                organizations/{organization}/locations/{location}/orgPolicyViolationsPreviews/{orgPolicyViolationsPreview}
 *                                Please see {@see OrgPolicyViolationsPreviewServiceClient::orgPolicyViolationsPreviewName()} for help formatting this field.
 */
function list_org_policy_violations_sample(string $formattedParent): void
{
    // Create a client.
    $orgPolicyViolationsPreviewServiceClient = new OrgPolicyViolationsPreviewServiceClient();

    // Prepare the request message.
    $request = (new ListOrgPolicyViolationsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $orgPolicyViolationsPreviewServiceClient->listOrgPolicyViolations($request);

        /** @var OrgPolicyViolation $element */
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
    $formattedParent = OrgPolicyViolationsPreviewServiceClient::orgPolicyViolationsPreviewName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[ORG_POLICY_VIOLATIONS_PREVIEW]'
    );

    list_org_policy_violations_sample($formattedParent);
}
// [END policysimulator_v1_generated_OrgPolicyViolationsPreviewService_ListOrgPolicyViolations_sync]
