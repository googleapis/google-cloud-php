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

// [START configdelivery_v1beta_generated_ConfigDelivery_AbortRollout_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ConfigDelivery\V1beta\AbortRolloutRequest;
use Google\Cloud\ConfigDelivery\V1beta\Client\ConfigDeliveryClient;
use Google\Cloud\ConfigDelivery\V1beta\Rollout;
use Google\Rpc\Status;

/**
 * Abort a Rollout.
 *
 * @param string $formattedName Name of the Rollout. Please see
 *                              {@see ConfigDeliveryClient::rolloutName()} for help formatting this field.
 */
function abort_rollout_sample(string $formattedName): void
{
    // Create a client.
    $configDeliveryClient = new ConfigDeliveryClient();

    // Prepare the request message.
    $request = (new AbortRolloutRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $configDeliveryClient->abortRollout($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Rollout $result */
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
    $formattedName = ConfigDeliveryClient::rolloutName(
        '[PROJECT]',
        '[LOCATION]',
        '[FLEET_PACKAGE]',
        '[ROLLOUT]'
    );

    abort_rollout_sample($formattedName);
}
// [END configdelivery_v1beta_generated_ConfigDelivery_AbortRollout_sync]
