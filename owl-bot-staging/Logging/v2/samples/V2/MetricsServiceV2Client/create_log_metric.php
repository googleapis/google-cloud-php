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

// [START logging_v2_generated_MetricsServiceV2_CreateLogMetric_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\MetricsServiceV2Client;

/**
 * Creates a logs-based metric.
 *
 * @param string $formattedParent The resource name of the project in which to create the metric:
 *
 *                                "projects/[PROJECT_ID]"
 *
 *                                The new metric must be provided in the request. Please see
 *                                {@see MetricsServiceV2Client::projectName()} for help formatting this field.
 * @param string $metricName      The client-assigned metric identifier.
 *                                Examples: `"error_count"`, `"nginx/requests"`.
 *
 *                                Metric identifiers are limited to 100 characters and can include only the
 *                                following characters: `A-Z`, `a-z`, `0-9`, and the special characters
 *                                `_-.,+!*',()%/`. The forward-slash character (`/`) denotes a hierarchy of
 *                                name pieces, and it cannot be the first character of the name.
 *
 *                                This field is the `[METRIC_ID]` part of a metric resource name in the
 *                                format "projects/[PROJECT_ID]/metrics/[METRIC_ID]". Example: If the
 *                                resource name of a metric is
 *                                `"projects/my-project/metrics/nginx%2Frequests"`, this field's value is
 *                                `"nginx/requests"`.
 * @param string $metricFilter    An [advanced logs
 *                                filter](https://cloud.google.com/logging/docs/view/advanced_filters) which
 *                                is used to match log entries. Example:
 *
 *                                "resource.type=gae_app AND severity>=ERROR"
 *
 *                                The maximum length of the filter is 20000 characters.
 */
function create_log_metric_sample(
    string $formattedParent,
    string $metricName,
    string $metricFilter
): void {
    // Create a client.
    $metricsServiceV2Client = new MetricsServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $metric = (new LogMetric())
        ->setName($metricName)
        ->setFilter($metricFilter);

    // Call the API and handle any network failures.
    try {
        /** @var LogMetric $response */
        $response = $metricsServiceV2Client->createLogMetric($formattedParent, $metric);
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
    $formattedParent = MetricsServiceV2Client::projectName('[PROJECT]');
    $metricName = '[NAME]';
    $metricFilter = '[FILTER]';

    create_log_metric_sample($formattedParent, $metricName, $metricFilter);
}
// [END logging_v2_generated_MetricsServiceV2_CreateLogMetric_sync]
