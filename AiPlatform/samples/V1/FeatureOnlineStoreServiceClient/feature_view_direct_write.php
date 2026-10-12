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

// [START aiplatform_v1_generated_FeatureOnlineStoreService_FeatureViewDirectWrite_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\AIPlatform\V1\Client\FeatureOnlineStoreServiceClient;
use Google\Cloud\AIPlatform\V1\FeatureViewDirectWriteRequest;
use Google\Cloud\AIPlatform\V1\FeatureViewDirectWriteRequest\DataKeyAndFeatureValues;
use Google\Cloud\AIPlatform\V1\FeatureViewDirectWriteResponse;

/**
 * Bidirectional streaming RPC to directly write to feature values in a
 * feature view. Requests may not have a one-to-one mapping to responses and
 * responses may be returned out-of-order to reduce latency.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function feature_view_direct_write_sample(): void
{
    // Create a client.
    $featureOnlineStoreServiceClient = new FeatureOnlineStoreServiceClient();

    // Prepare the request message.
    $dataKeyAndFeatureValues = [new DataKeyAndFeatureValues()];
    $request = (new FeatureViewDirectWriteRequest())
        ->setDataKeyAndFeatureValues($dataKeyAndFeatureValues);

    // Call the API and handle any network failures.
    try {
        /** @var BidiStream $stream */
        $stream = $featureOnlineStoreServiceClient->featureViewDirectWrite();
        $stream->writeAll([$request,]);

        /** @var FeatureViewDirectWriteResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END aiplatform_v1_generated_FeatureOnlineStoreService_FeatureViewDirectWrite_sync]
