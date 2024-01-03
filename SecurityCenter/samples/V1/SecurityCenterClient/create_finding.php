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

// [START securitycenter_v1_generated_SecurityCenter_CreateFinding_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V1\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\CreateFindingRequest;
use Google\Cloud\SecurityCenter\V1\Finding;

/**
 * Creates a finding. The corresponding source must exist for finding creation
 * to succeed.
 *
 * @param string $formattedParent Resource name of the new finding's parent. Its format should be
 *                                "organizations/[organization_id]/sources/[source_id]". Please see
 *                                {@see SecurityCenterClient::sourceName()} for help formatting this field.
 * @param string $findingId       Unique identifier provided by the client within the parent scope.
 *                                It must be alphanumeric and less than or equal to 32 characters and
 *                                greater than 0 characters in length.
 */
function create_finding_sample(string $formattedParent, string $findingId): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $finding = new Finding();
    $request = (new CreateFindingRequest())
        ->setParent($formattedParent)
        ->setFindingId($findingId)
        ->setFinding($finding);

    // Call the API and handle any network failures.
    try {
        /** @var Finding $response */
        $response = $securityCenterClient->createFinding($request);
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
    $formattedParent = SecurityCenterClient::sourceName('[ORGANIZATION]', '[SOURCE]');
    $findingId = '[FINDING_ID]';

    create_finding_sample($formattedParent, $findingId);
}
// [END securitycenter_v1_generated_SecurityCenter_CreateFinding_sync]
