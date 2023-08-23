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

// [START cloudresourcemanager_v3_generated_TagValues_UpdateTagValue_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Client\TagValuesClient;
use Google\Cloud\ResourceManager\V3\TagValue;
use Google\Cloud\ResourceManager\V3\UpdateTagValueRequest;
use Google\Rpc\Status;

/**
 * Updates the attributes of the TagValue resource.
 *
 * @param string $tagValueShortName Immutable. User-assigned short name for TagValue. The short name
 *                                  should be unique for TagValues within the same parent TagKey.
 *
 *                                  The short name must be 63 characters or less, beginning and ending with
 *                                  an alphanumeric character ([a-z0-9A-Z]) with dashes (-), underscores (_),
 *                                  dots (.), and alphanumerics between.
 */
function update_tag_value_sample(string $tagValueShortName): void
{
    // Create a client.
    $tagValuesClient = new TagValuesClient();

    // Prepare the request message.
    $tagValue = (new TagValue())
        ->setShortName($tagValueShortName);
    $request = (new UpdateTagValueRequest())
        ->setTagValue($tagValue);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $tagValuesClient->updateTagValue($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TagValue $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $tagValueShortName = '[SHORT_NAME]';

    update_tag_value_sample($tagValueShortName);
}
// [END cloudresourcemanager_v3_generated_TagValues_UpdateTagValue_sync]
