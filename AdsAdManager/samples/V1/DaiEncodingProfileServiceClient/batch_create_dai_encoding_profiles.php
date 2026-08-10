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

// [START admanager_v1_generated_DaiEncodingProfileService_BatchCreateDaiEncodingProfiles_sync]
use Google\Ads\AdManager\V1\BatchCreateDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchCreateDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\Client\DaiEncodingProfileServiceClient;
use Google\Ads\AdManager\V1\ContainerTypeEnum\ContainerType;
use Google\Ads\AdManager\V1\CreateDaiEncodingProfileRequest;
use Google\Ads\AdManager\V1\DaiEncodingProfile;
use Google\Ads\AdManager\V1\DaiEncodingProfileVariantTypeEnum\DaiEncodingProfileVariantType;
use Google\ApiCore\ApiException;

/**
 * Batch creates `DaiEncodingProfile` objects.
 *
 * @param string $formattedParent                         The parent resource where `DaiEncodingProfiles` will be created.
 *                                                        Format: `networks/{network_code}`
 *                                                        The parent field in the CreateDaiEncodingProfileRequest must match this
 *                                                        field. Please see
 *                                                        {@see DaiEncodingProfileServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                 The parent resource where this `DaiEncodingProfile` will be
 *                                                        created. Format: `networks/{network_code}`
 *                                                        Please see {@see DaiEncodingProfileServiceClient::networkName()} for help formatting this field.
 * @param string $requestsDaiEncodingProfileDisplayName   The name of the DaiEncodingProfile. It may be at most 64
 *                                                        characters. The name field can contain alphanumeric characters and symbols
 *                                                        other than the following: ", ', =, !, +, #, , ~, ;, ^, (, ), <, >, [, ],
 *                                                        the white space character.
 * @param int    $requestsDaiEncodingProfileVariantType   The variant playlist type that this DaiEncodingProfile
 *                                                        represents.
 * @param int    $requestsDaiEncodingProfileContainerType The digital container type of the underlying media. This is
 *                                                        required for MEDIA and IFRAME variant types.
 */
function batch_create_dai_encoding_profiles_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsDaiEncodingProfileDisplayName,
    int $requestsDaiEncodingProfileVariantType,
    int $requestsDaiEncodingProfileContainerType
): void {
    // Create a client.
    $daiEncodingProfileServiceClient = new DaiEncodingProfileServiceClient();

    // Prepare the request message.
    $requestsDaiEncodingProfile = (new DaiEncodingProfile())
        ->setDisplayName($requestsDaiEncodingProfileDisplayName)
        ->setVariantType($requestsDaiEncodingProfileVariantType)
        ->setContainerType($requestsDaiEncodingProfileContainerType);
    $createDaiEncodingProfileRequest = (new CreateDaiEncodingProfileRequest())
        ->setParent($formattedRequestsParent)
        ->setDaiEncodingProfile($requestsDaiEncodingProfile);
    $requests = [$createDaiEncodingProfileRequest,];
    $request = (new BatchCreateDaiEncodingProfilesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateDaiEncodingProfilesResponse $response */
        $response = $daiEncodingProfileServiceClient->batchCreateDaiEncodingProfiles($request);
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
    $formattedParent = DaiEncodingProfileServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = DaiEncodingProfileServiceClient::networkName('[NETWORK_CODE]');
    $requestsDaiEncodingProfileDisplayName = '[DISPLAY_NAME]';
    $requestsDaiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
    $requestsDaiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;

    batch_create_dai_encoding_profiles_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsDaiEncodingProfileDisplayName,
        $requestsDaiEncodingProfileVariantType,
        $requestsDaiEncodingProfileContainerType
    );
}
// [END admanager_v1_generated_DaiEncodingProfileService_BatchCreateDaiEncodingProfiles_sync]
