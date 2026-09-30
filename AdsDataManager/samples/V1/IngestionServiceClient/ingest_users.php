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

// [START datamanager_v1_generated_IngestionService_IngestUsers_sync]
use Google\Ads\DataManager\V1\Client\IngestionServiceClient;
use Google\Ads\DataManager\V1\Destination;
use Google\Ads\DataManager\V1\Encoding;
use Google\Ads\DataManager\V1\IngestUsersRequest;
use Google\Ads\DataManager\V1\IngestUsersResponse;
use Google\Ads\DataManager\V1\MobileData;
use Google\Ads\DataManager\V1\ProductAccount;
use Google\Ads\DataManager\V1\ProductAccount\AccountType;
use Google\Ads\DataManager\V1\User;
use Google\Ads\DataManager\V1\UserData;
use Google\Ads\DataManager\V1\UserIdentifier;
use Google\ApiCore\ApiException;

/**
 * Uploads a list of users to the provided destinations. Unlike
 * [IngestAudienceMembers][google.ads.datamanager.v1.IngestionService.IngestAudienceMembers]
 * (which adds users to specific advertiser audience lists for targeting),
 * `IngestUsers` ingests account level identity linkage data (for example,
 * user identifiers linked to mobile IDs) independent of specific audience
 * segments.
 *
 * This feature is only available to accounts on an allowlist.
 *
 * @param string $destinationsOperatingAccountAccountId   The ID of the account. For example, your Google Ads account ID.
 * @param int    $destinationsOperatingAccountAccountType The type of the account. For example, `GOOGLE_ADS`.
 *                                                        Either `account_type` or the deprecated `product` is required.
 *                                                        If both are set, the values must match.
 * @param string $usersMobileDataMobileIdsElement         The list of mobile device IDs (Android advertising ID, iOS IDFA
 *                                                        for Customer Match user lists and Android advertising ID, iOS IDFA,
 *                                                        Xbox or Microsoft ID, Amazon Fire TV ID, Roku ID, Generic Device ID for
 *                                                        basic user lists). At most 10 `mobileIds` can be provided in a single
 *                                                        [AudienceMember][google.ads.datamanager.v1.AudienceMember].
 * @param int    $encoding                                The encoding type of the user identifiers. For encrypted user
 *                                                        identifiers, this only applies to the outer encoding.
 */
function ingest_users_sample(
    string $destinationsOperatingAccountAccountId,
    int $destinationsOperatingAccountAccountType,
    string $usersMobileDataMobileIdsElement,
    int $encoding
): void {
    // Create a client.
    $ingestionServiceClient = new IngestionServiceClient();

    // Prepare the request message.
    $destinationsOperatingAccount = (new ProductAccount())
        ->setAccountId($destinationsOperatingAccountAccountId)
        ->setAccountType($destinationsOperatingAccountAccountType);
    $destination = (new Destination())
        ->setOperatingAccount($destinationsOperatingAccount);
    $destinations = [$destination,];
    $usersUserDataUserIdentifiers = [new UserIdentifier()];
    $usersUserData = (new UserData())
        ->setUserIdentifiers($usersUserDataUserIdentifiers);
    $usersMobileDataMobileIds = [$usersMobileDataMobileIdsElement,];
    $usersMobileData = (new MobileData())
        ->setMobileIds($usersMobileDataMobileIds);
    $user = (new User())
        ->setUserData($usersUserData)
        ->setMobileData($usersMobileData);
    $users = [$user,];
    $request = (new IngestUsersRequest())
        ->setDestinations($destinations)
        ->setUsers($users)
        ->setEncoding($encoding);

    // Call the API and handle any network failures.
    try {
        /** @var IngestUsersResponse $response */
        $response = $ingestionServiceClient->ingestUsers($request);
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
    $destinationsOperatingAccountAccountType = AccountType::ACCOUNT_TYPE_UNSPECIFIED;
    $usersMobileDataMobileIdsElement = '[MOBILE_IDS]';
    $encoding = Encoding::ENCODING_UNSPECIFIED;

    ingest_users_sample(
        $destinationsOperatingAccountAccountId,
        $destinationsOperatingAccountAccountType,
        $usersMobileDataMobileIdsElement,
        $encoding
    );
}
// [END datamanager_v1_generated_IngestionService_IngestUsers_sync]
