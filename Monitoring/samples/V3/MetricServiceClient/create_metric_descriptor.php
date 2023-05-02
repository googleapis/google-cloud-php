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

// [START monitoring_v3_generated_MetricService_CreateMetricDescriptor_sync]
use Google\ApiCore\ApiException;
use Google\Api\MetricDescriptor;
use Google\Cloud\Monitoring\V3\MetricServiceClient;

/**
 * Creates a new metric descriptor.
 * The creation is executed asynchronously and callers may check the returned
 * operation to track its progress.
 * User-created metric descriptors define
 * [custom metrics](https://cloud.google.com/monitoring/custom-metrics).
 *
 * @param string $name The [project](https://cloud.google.com/monitoring/api/v3#project_name) on
 *                     which to execute the request. The format is:
 *                     4
 *                     projects/[PROJECT_ID_OR_NUMBER]
 */
function create_metric_descriptor_sample(string $name): void
{
    // Create a client.
    $metricServiceClient = new MetricServiceClient();

    // Prepare the request message.
    $metricDescriptor = new MetricDescriptor();

    // Call the API and handle any network failures.
    try {
        /** @var MetricDescriptor $response */
        $response = $metricServiceClient->createMetricDescriptor($name, $metricDescriptor);
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
    $name = '[NAME]';

    create_metric_descriptor_sample($name);
}
// [END monitoring_v3_generated_MetricService_CreateMetricDescriptor_sync]
