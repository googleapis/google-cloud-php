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

// [START admanager_v1_generated_PartnerService_UpdatePartner_sync]
use Google\Ads\AdManager\V1\Client\PartnerServiceClient;
use Google\Ads\AdManager\V1\Partner;
use Google\Ads\AdManager\V1\UpdatePartnerRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a [Partner][google.ads.admanager.v1.Partner] object.
 *
 * @param string $partnerDisplayName The display name of the
 *                                   [Partner][google.ads.admanager.v1.Partner].
 */
function update_partner_sample(string $partnerDisplayName): void
{
    // Create a client.
    $partnerServiceClient = new PartnerServiceClient();

    // Prepare the request message.
    $partner = (new Partner())
        ->setDisplayName($partnerDisplayName);
    $request = (new UpdatePartnerRequest())
        ->setPartner($partner);

    // Call the API and handle any network failures.
    try {
        /** @var Partner $response */
        $response = $partnerServiceClient->updatePartner($request);
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
    $partnerDisplayName = '[DISPLAY_NAME]';

    update_partner_sample($partnerDisplayName);
}
// [END admanager_v1_generated_PartnerService_UpdatePartner_sync]
