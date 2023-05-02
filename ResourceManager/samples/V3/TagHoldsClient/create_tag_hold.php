<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudresourcemanager_v3_generated_TagHolds_CreateTagHold_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\TagHold;
use Google\Cloud\ResourceManager\V3\TagHoldsClient;
use Google\Rpc\Status;

/**
 * Creates a TagHold. Returns ALREADY_EXISTS if a TagHold with the same
 * resource and origin exists under the same TagValue.
 *
 * @param string $formattedParent The resource name of the TagHold's parent TagValue. Must be of
 *                                the form: `tagValues/{tag-value-id}`. Please see
 *                                {@see TagHoldsClient::tagValueName()} for help formatting this field.
 * @param string $tagHoldHolder   The name of the resource where the TagValue is being used. Must
 *                                be less than 200 characters. E.g.
 *                                `//compute.googleapis.com/compute/projects/myproject/regions/us-east-1/instanceGroupManagers/instance-group`
 */
function create_tag_hold_sample(string $formattedParent, string $tagHoldHolder): void
{
    // Create a client.
    $tagHoldsClient = new TagHoldsClient();

    // Prepare the request message.
    $tagHold = (new TagHold())
        ->setHolder($tagHoldHolder);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $tagHoldsClient->createTagHold($formattedParent, $tagHold);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TagHold $result */
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
    $formattedParent = TagHoldsClient::tagValueName('[TAG_VALUE]');
    $tagHoldHolder = '[HOLDER]';

    create_tag_hold_sample($formattedParent, $tagHoldHolder);
}
// [END cloudresourcemanager_v3_generated_TagHolds_CreateTagHold_sync]
