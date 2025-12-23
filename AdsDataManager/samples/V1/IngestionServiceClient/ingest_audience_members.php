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

// [START datamanager_v1_generated_IngestionService_IngestAudienceMembers_sync]
use Google\Ads\DataManager\V1\AudienceMember;
use Google\Ads\DataManager\V1\Client\IngestionServiceClient;
use Google\Ads\DataManager\V1\Destination;
use Google\Ads\DataManager\V1\IngestAudienceMembersRequest;
use Google\Ads\DataManager\V1\IngestAudienceMembersResponse;
use Google\Ads\DataManager\V1\ProductAccount;
use Google\ApiCore\ApiException;

/**
 * Uploads a list of
 * [AudienceMember][google.ads.datamanager.v1.AudienceMember] resources to the
 * provided [Destination][google.ads.datamanager.v1.Destination].
 *
 * @param string $destinationsOperatingAccountAccountId The ID of the account. For example, your Google Ads account ID.
 * @param string $destinationsProductDestinationId      The object within the product account to ingest into. For
 *                                                      example, a Google Ads audience ID, a Display & Video 360 audience ID or a
 *                                                      Google Ads conversion action ID.
 */
function ingest_audience_members_sample(
    string $destinationsOperatingAccountAccountId,
    string $destinationsProductDestinationId
): void {
    // Create a client.
    $ingestionServiceClient = new IngestionServiceClient();

    // Prepare the request message.
    $destinationsOperatingAccount = (new ProductAccount())
        ->setAccountId($destinationsOperatingAccountAccountId);
    $destination = (new Destination())
        ->setOperatingAccount($destinationsOperatingAccount)
        ->setProductDestinationId($destinationsProductDestinationId);
    $destinations = [$destination,];
    $audienceMembers = [new AudienceMember()];
    $request = (new IngestAudienceMembersRequest())
        ->setDestinations($destinations)
        ->setAudienceMembers($audienceMembers);

    // Call the API and handle any network failures.
    try {
        /** @var IngestAudienceMembersResponse $response */
        $response = $ingestionServiceClient->ingestAudienceMembers($request);
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
    $destinationsOperatingAccountAccountId = '[ACCOUNT_ID]';
    $destinationsProductDestinationId = '[PRODUCT_DESTINATION_ID]';

    ingest_audience_members_sample(
        $destinationsOperatingAccountAccountId,
        $destinationsProductDestinationId
    );
}
// [END datamanager_v1_generated_IngestionService_IngestAudienceMembers_sync]
