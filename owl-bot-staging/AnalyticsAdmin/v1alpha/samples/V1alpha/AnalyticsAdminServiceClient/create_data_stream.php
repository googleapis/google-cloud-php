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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateDataStream_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\DataStream;
use Google\Analytics\Admin\V1alpha\DataStream\DataStreamType;
use Google\ApiCore\ApiException;

/**
 * Creates a DataStream.
 *
 * @param string $formattedParent Example format: properties/1234
 *                                Please see {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param int    $dataStreamType  Immutable. The type of this DataStream resource.
 */
function create_data_stream_sample(string $formattedParent, int $dataStreamType): void
{
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $dataStream = (new DataStream())
        ->setType($dataStreamType);

    // Call the API and handle any network failures.
    try {
        /** @var DataStream $response */
        $response = $analyticsAdminServiceClient->createDataStream($formattedParent, $dataStream);
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
    $formattedParent = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');
    $dataStreamType = DataStreamType::DATA_STREAM_TYPE_UNSPECIFIED;

    create_data_stream_sample($formattedParent, $dataStreamType);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_CreateDataStream_sync]
