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

// [START datamanager_v1_generated_IngestionService_IngestAdEvents_sync]
use Google\Ads\DataManager\V1\AdEvent;
use Google\Ads\DataManager\V1\AdEvent\EventType;
use Google\Ads\DataManager\V1\Client\IngestionServiceClient;
use Google\Ads\DataManager\V1\IngestAdEventsRequest;
use Google\Ads\DataManager\V1\IngestAdEventsResponse;
use Google\Ads\DataManager\V1\ViewType;
use Google\Ads\DataManager\V1\ViewabilityInfo;
use Google\ApiCore\ApiException;
use Google\Protobuf\Timestamp;

/**
 * Uploads a list of
 * [AdEvent][google.ads.datamanager.v1.AdEvent] resources to Google
 * Analytics.
 *
 * This feature is only available to accounts on an allowlist.
 *
 * @param string $adEventsAdvertiserId            The ID of the advertiser for the ad event.
 *
 *                                                This must match the ID sent in the linking flow.
 * @param int    $adEventsEventType               The type of the event.
 * @param string $adEventsCampaignId              The ID of the associated campaign.
 * @param string $adEventsCampaignName            The name of the associated campaign.
 * @param string $adEventsRegionCode              The ISO 3166-2 country plus subdivision.
 * @param string $adEventsSource                  The platform source of the ad, akin to the Google Analytics
 *                                                source.
 * @param string $adEventsMedium                  The medium of the ad, akin to the Google Analytics medium.
 * @param int    $adEventsViewabilityInfoViewType The type of the event.
 */
function ingest_ad_events_sample(
    string $adEventsAdvertiserId,
    int $adEventsEventType,
    string $adEventsCampaignId,
    string $adEventsCampaignName,
    string $adEventsRegionCode,
    string $adEventsSource,
    string $adEventsMedium,
    int $adEventsViewabilityInfoViewType
): void {
    // Create a client.
    $ingestionServiceClient = new IngestionServiceClient();

    // Prepare the request message.
    $adEventsTimestamp = new Timestamp();
    $adEventsViewabilityInfo = (new ViewabilityInfo())
        ->setViewType($adEventsViewabilityInfoViewType);
    $adEvent = (new AdEvent())
        ->setAdvertiserId($adEventsAdvertiserId)
        ->setEventType($adEventsEventType)
        ->setTimestamp($adEventsTimestamp)
        ->setCampaignId($adEventsCampaignId)
        ->setCampaignName($adEventsCampaignName)
        ->setRegionCode($adEventsRegionCode)
        ->setSource($adEventsSource)
        ->setMedium($adEventsMedium)
        ->setViewabilityInfo($adEventsViewabilityInfo);
    $adEvents = [$adEvent,];
    $request = (new IngestAdEventsRequest())
        ->setAdEvents($adEvents);

    // Call the API and handle any network failures.
    try {
        /** @var IngestAdEventsResponse $response */
        $response = $ingestionServiceClient->ingestAdEvents($request);
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
    $adEventsAdvertiserId = '[ADVERTISER_ID]';
    $adEventsEventType = EventType::EVENT_TYPE_UNSPECIFIED;
    $adEventsCampaignId = '[CAMPAIGN_ID]';
    $adEventsCampaignName = '[CAMPAIGN_NAME]';
    $adEventsRegionCode = '[REGION_CODE]';
    $adEventsSource = '[SOURCE]';
    $adEventsMedium = '[MEDIUM]';
    $adEventsViewabilityInfoViewType = ViewType::VIEW_TYPE_UNSPECIFIED;

    ingest_ad_events_sample(
        $adEventsAdvertiserId,
        $adEventsEventType,
        $adEventsCampaignId,
        $adEventsCampaignName,
        $adEventsRegionCode,
        $adEventsSource,
        $adEventsMedium,
        $adEventsViewabilityInfoViewType
    );
}
// [END datamanager_v1_generated_IngestionService_IngestAdEvents_sync]
