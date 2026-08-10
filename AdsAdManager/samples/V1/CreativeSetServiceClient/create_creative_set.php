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

// [START admanager_v1_generated_CreativeSetService_CreateCreativeSet_sync]
use Google\Ads\AdManager\V1\Client\CreativeSetServiceClient;
use Google\Ads\AdManager\V1\CreateCreativeSetRequest;
use Google\Ads\AdManager\V1\CreativeSet;
use Google\ApiCore\ApiException;

/**
 * Creates a `CreativeSet` object.
 *
 * @param string $formattedParent                               The parent resource where this `CreativeSet` will be created.
 *                                                              Format: `networks/{network_code}`
 *                                                              Please see {@see CreativeSetServiceClient::networkName()} for help formatting this field.
 * @param string $creativeSetDisplayName                        The name of the `CreativeSet`. This attribute has a maximum
 *                                                              length of 255 characters.
 * @param string $formattedCreativeSetMasterCreative            Immutable. The master
 *                                                              [Creative](google.ads.admanager.v1.Creative) to which the `CreativeSet` is
 *                                                              associated. Please see
 *                                                              {@see CreativeSetServiceClient::creativeName()} for help formatting this field.
 * @param string $formattedCreativeSetCompanionCreativesElement The resource names of the companion `Creative`s associated with
 *                                                              this `CreativeSet`. Format: `networks/{network_code}/creatives/{creative}`
 *                                                              Please see {@see CreativeSetServiceClient::creativeName()} for help formatting this field.
 */
function create_creative_set_sample(
    string $formattedParent,
    string $creativeSetDisplayName,
    string $formattedCreativeSetMasterCreative,
    string $formattedCreativeSetCompanionCreativesElement
): void {
    // Create a client.
    $creativeSetServiceClient = new CreativeSetServiceClient();

    // Prepare the request message.
    $formattedCreativeSetCompanionCreatives = [$formattedCreativeSetCompanionCreativesElement,];
    $creativeSet = (new CreativeSet())
        ->setDisplayName($creativeSetDisplayName)
        ->setMasterCreative($formattedCreativeSetMasterCreative)
        ->setCompanionCreatives($formattedCreativeSetCompanionCreatives);
    $request = (new CreateCreativeSetRequest())
        ->setParent($formattedParent)
        ->setCreativeSet($creativeSet);

    // Call the API and handle any network failures.
    try {
        /** @var CreativeSet $response */
        $response = $creativeSetServiceClient->createCreativeSet($request);
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
    $formattedParent = CreativeSetServiceClient::networkName('[NETWORK_CODE]');
    $creativeSetDisplayName = '[DISPLAY_NAME]';
    $formattedCreativeSetMasterCreative = CreativeSetServiceClient::creativeName(
        '[NETWORK_CODE]',
        '[CREATIVE]'
    );
    $formattedCreativeSetCompanionCreativesElement = CreativeSetServiceClient::creativeName(
        '[NETWORK_CODE]',
        '[CREATIVE]'
    );

    create_creative_set_sample(
        $formattedParent,
        $creativeSetDisplayName,
        $formattedCreativeSetMasterCreative,
        $formattedCreativeSetCompanionCreativesElement
    );
}
// [END admanager_v1_generated_CreativeSetService_CreateCreativeSet_sync]
