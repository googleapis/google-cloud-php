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

// [START apihub_v1_generated_LintingService_UpdateStyleGuide_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\LintingServiceClient;
use Google\Cloud\ApiHub\V1\Linter;
use Google\Cloud\ApiHub\V1\StyleGuide;
use Google\Cloud\ApiHub\V1\StyleGuideContents;
use Google\Cloud\ApiHub\V1\UpdateStyleGuideRequest;

/**
 * Update the styleGuide to be used for liniting in by API hub.
 *
 * @param int    $styleGuideLinter           Target linter for the style guide.
 * @param string $styleGuideContentsContents The contents of the style guide.
 * @param string $styleGuideContentsMimeType The mime type of the content.
 */
function update_style_guide_sample(
    int $styleGuideLinter,
    string $styleGuideContentsContents,
    string $styleGuideContentsMimeType
): void {
    // Create a client.
    $lintingServiceClient = new LintingServiceClient();

    // Prepare the request message.
    $styleGuideContents = (new StyleGuideContents())
        ->setContents($styleGuideContentsContents)
        ->setMimeType($styleGuideContentsMimeType);
    $styleGuide = (new StyleGuide())
        ->setLinter($styleGuideLinter)
        ->setContents($styleGuideContents);
    $request = (new UpdateStyleGuideRequest())
        ->setStyleGuide($styleGuide);

    // Call the API and handle any network failures.
    try {
        /** @var StyleGuide $response */
        $response = $lintingServiceClient->updateStyleGuide($request);
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
    $styleGuideLinter = Linter::LINTER_UNSPECIFIED;
    $styleGuideContentsContents = '...';
    $styleGuideContentsMimeType = '[MIME_TYPE]';

    update_style_guide_sample(
        $styleGuideLinter,
        $styleGuideContentsContents,
        $styleGuideContentsMimeType
    );
}
// [END apihub_v1_generated_LintingService_UpdateStyleGuide_sync]
