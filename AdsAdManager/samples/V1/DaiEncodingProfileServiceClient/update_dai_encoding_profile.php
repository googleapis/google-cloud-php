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

// [START admanager_v1_generated_DaiEncodingProfileService_UpdateDaiEncodingProfile_sync]
use Google\Ads\AdManager\V1\Client\DaiEncodingProfileServiceClient;
use Google\Ads\AdManager\V1\ContainerTypeEnum\ContainerType;
use Google\Ads\AdManager\V1\DaiEncodingProfile;
use Google\Ads\AdManager\V1\DaiEncodingProfileVariantTypeEnum\DaiEncodingProfileVariantType;
use Google\Ads\AdManager\V1\UpdateDaiEncodingProfileRequest;
use Google\ApiCore\ApiException;

/**
 * Updates a `DaiEncodingProfile` object.
 *
 * @param string $daiEncodingProfileDisplayName   The name of the DaiEncodingProfile. It may be at most 64
 *                                                characters. The name field can contain alphanumeric characters and symbols
 *                                                other than the following: ", ', =, !, +, #, , ~, ;, ^, (, ), <, >, [, ],
 *                                                the white space character.
 * @param int    $daiEncodingProfileVariantType   The variant playlist type that this DaiEncodingProfile
 *                                                represents.
 * @param int    $daiEncodingProfileContainerType The digital container type of the underlying media. This is
 *                                                required for MEDIA and IFRAME variant types.
 */
function update_dai_encoding_profile_sample(
    string $daiEncodingProfileDisplayName,
    int $daiEncodingProfileVariantType,
    int $daiEncodingProfileContainerType
): void {
    // Create a client.
    $daiEncodingProfileServiceClient = new DaiEncodingProfileServiceClient();

    // Prepare the request message.
    $daiEncodingProfile = (new DaiEncodingProfile())
        ->setDisplayName($daiEncodingProfileDisplayName)
        ->setVariantType($daiEncodingProfileVariantType)
        ->setContainerType($daiEncodingProfileContainerType);
    $request = (new UpdateDaiEncodingProfileRequest())
        ->setDaiEncodingProfile($daiEncodingProfile);

    // Call the API and handle any network failures.
    try {
        /** @var DaiEncodingProfile $response */
        $response = $daiEncodingProfileServiceClient->updateDaiEncodingProfile($request);
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
    $daiEncodingProfileDisplayName = '[DISPLAY_NAME]';
    $daiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
    $daiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;

    update_dai_encoding_profile_sample(
        $daiEncodingProfileDisplayName,
        $daiEncodingProfileVariantType,
        $daiEncodingProfileContainerType
    );
}
// [END admanager_v1_generated_DaiEncodingProfileService_UpdateDaiEncodingProfile_sync]
