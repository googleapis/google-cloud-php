<?php
/*
 * Copyright 2024 Google LLC
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

// [START securitycenter_v2_generated_SecurityCenter_CreateSource_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\SecurityCenter\V2\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V2\CreateSourceRequest;
use Google\Cloud\SecurityCenter\V2\Source;

/**
 * Creates a source.
 *
 * @param string $formattedParent Resource name of the new source's parent. Its format should be
 *                                `organizations/[organization_id]`. Please see
 *                                {@see SecurityCenterClient::organizationName()} for help formatting this field.
 */
function create_source_sample(string $formattedParent): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Prepare the request message.
    $source = new Source();
    $request = (new CreateSourceRequest())
        ->setParent($formattedParent)
        ->setSource($source);

    // Call the API and handle any network failures.
    try {
        /** @var Source $response */
        $response = $securityCenterClient->createSource($request);
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
    $formattedParent = SecurityCenterClient::organizationName('[ORGANIZATION]');

    create_source_sample($formattedParent);
}
// [END securitycenter_v2_generated_SecurityCenter_CreateSource_sync]
