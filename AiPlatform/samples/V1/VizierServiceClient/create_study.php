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

// [START aiplatform_v1_generated_VizierService_CreateStudy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Study;
use Google\Cloud\AIPlatform\V1\StudySpec;
use Google\Cloud\AIPlatform\V1\StudySpec\MetricSpec;
use Google\Cloud\AIPlatform\V1\StudySpec\MetricSpec\GoalType;
use Google\Cloud\AIPlatform\V1\StudySpec\ParameterSpec;
use Google\Cloud\AIPlatform\V1\VizierServiceClient;

/**
 * Creates a Study. A resource name will be generated after creation of the
 * Study.
 *
 * @param string $formattedParent                     The resource name of the Location to create the CustomJob in.
 *                                                    Format: `projects/{project}/locations/{location}`
 *                                                    Please see {@see VizierServiceClient::locationName()} for help formatting this field.
 * @param string $studyDisplayName                    Describes the Study, default value is empty string.
 * @param string $studyStudySpecMetricsMetricId       The ID of the metric. Must not contain whitespaces and must be unique
 *                                                    amongst all MetricSpecs.
 * @param int    $studyStudySpecMetricsGoal           The optimization goal of the metric.
 * @param string $studyStudySpecParametersParameterId The ID of the parameter. Must not contain whitespaces and must be unique
 *                                                    amongst all ParameterSpecs.
 */
function create_study_sample(
    string $formattedParent,
    string $studyDisplayName,
    string $studyStudySpecMetricsMetricId,
    int $studyStudySpecMetricsGoal,
    string $studyStudySpecParametersParameterId
): void {
    // Create a client.
    $vizierServiceClient = new VizierServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $metricSpec = (new MetricSpec())
        ->setMetricId($studyStudySpecMetricsMetricId)
        ->setGoal($studyStudySpecMetricsGoal);
    $studyStudySpecMetrics = [$metricSpec,];
    $parameterSpec = (new ParameterSpec())
        ->setParameterId($studyStudySpecParametersParameterId);
    $studyStudySpecParameters = [$parameterSpec,];
    $studyStudySpec = (new StudySpec())
        ->setMetrics($studyStudySpecMetrics)
        ->setParameters($studyStudySpecParameters);
    $study = (new Study())
        ->setDisplayName($studyDisplayName)
        ->setStudySpec($studyStudySpec);

    // Call the API and handle any network failures.
    try {
        /** @var Study $response */
        $response = $vizierServiceClient->createStudy($formattedParent, $study);
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
    $formattedParent = VizierServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $studyDisplayName = '[DISPLAY_NAME]';
    $studyStudySpecMetricsMetricId = '[METRIC_ID]';
    $studyStudySpecMetricsGoal = GoalType::GOAL_TYPE_UNSPECIFIED;
    $studyStudySpecParametersParameterId = '[PARAMETER_ID]';

    create_study_sample(
        $formattedParent,
        $studyDisplayName,
        $studyStudySpecMetricsMetricId,
        $studyStudySpecMetricsGoal,
        $studyStudySpecParametersParameterId
    );
}
// [END aiplatform_v1_generated_VizierService_CreateStudy_sync]
