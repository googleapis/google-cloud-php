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

// [START policysimulator_v1_generated_OrgPolicyViolationsPreviewService_CreateOrgPolicyViolationsPreview_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\PolicySimulator\V1\Client\OrgPolicyViolationsPreviewServiceClient;
use Google\Cloud\PolicySimulator\V1\CreateOrgPolicyViolationsPreviewRequest;
use Google\Cloud\PolicySimulator\V1\OrgPolicyOverlay;
use Google\Cloud\PolicySimulator\V1\OrgPolicyViolationsPreview;
use Google\Rpc\Status;

/**
 * CreateOrgPolicyViolationsPreview creates an
 * [OrgPolicyViolationsPreview][google.cloud.policysimulator.v1.OrgPolicyViolationsPreview]
 * for the proposed changes in the provided
 * [OrgPolicyViolationsPreview.OrgPolicyOverlay][]. The changes to OrgPolicy
 * are specified by this `OrgPolicyOverlay`. The resources to scan are
 * inferred from these specified changes.
 *
 * @param string $formattedParent The organization under which this
 *                                [OrgPolicyViolationsPreview][google.cloud.policysimulator.v1.OrgPolicyViolationsPreview]
 *                                will be created.
 *
 *                                Example: `organizations/my-example-org/locations/global`
 *                                Please see {@see OrgPolicyViolationsPreviewServiceClient::organizationLocationName()} for help formatting this field.
 */
function create_org_policy_violations_preview_sample(string $formattedParent): void
{
    // Create a client.
    $orgPolicyViolationsPreviewServiceClient = new OrgPolicyViolationsPreviewServiceClient();

    // Prepare the request message.
    $orgPolicyViolationsPreviewOverlay = new OrgPolicyOverlay();
    $orgPolicyViolationsPreview = (new OrgPolicyViolationsPreview())
        ->setOverlay($orgPolicyViolationsPreviewOverlay);
    $request = (new CreateOrgPolicyViolationsPreviewRequest())
        ->setParent($formattedParent)
        ->setOrgPolicyViolationsPreview($orgPolicyViolationsPreview);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $orgPolicyViolationsPreviewServiceClient->createOrgPolicyViolationsPreview($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var OrgPolicyViolationsPreview $result */
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
    $formattedParent = OrgPolicyViolationsPreviewServiceClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );

    create_org_policy_violations_preview_sample($formattedParent);
}
// [END policysimulator_v1_generated_OrgPolicyViolationsPreviewService_CreateOrgPolicyViolationsPreview_sync]
