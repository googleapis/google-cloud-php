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

// [START aiplatform_v1_generated_JobService_CreateHyperparameterTuningJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\CustomJobSpec;
use Google\Cloud\AIPlatform\V1\HyperparameterTuningJob;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Cloud\AIPlatform\V1\StudySpec;
use Google\Cloud\AIPlatform\V1\StudySpec\MetricSpec;
use Google\Cloud\AIPlatform\V1\StudySpec\MetricSpec\GoalType;
use Google\Cloud\AIPlatform\V1\StudySpec\ParameterSpec;
use Google\Cloud\AIPlatform\V1\WorkerPoolSpec;

/**
 * Creates a HyperparameterTuningJob
 *
 * @param string $formattedParent                                       The resource name of the Location to create the HyperparameterTuningJob in.
 *                                                                      Format: `projects/{project}/locations/{location}`
 *                                                                      Please see {@see JobServiceClient::locationName()} for help formatting this field.
 * @param string $hyperparameterTuningJobDisplayName                    The display name of the HyperparameterTuningJob.
 *                                                                      The name can be up to 128 characters long and can consist of any UTF-8
 *                                                                      characters.
 * @param string $hyperparameterTuningJobStudySpecMetricsMetricId       The ID of the metric. Must not contain whitespaces and must be unique
 *                                                                      amongst all MetricSpecs.
 * @param int    $hyperparameterTuningJobStudySpecMetricsGoal           The optimization goal of the metric.
 * @param string $hyperparameterTuningJobStudySpecParametersParameterId The ID of the parameter. Must not contain whitespaces and must be unique
 *                                                                      amongst all ParameterSpecs.
 * @param int    $hyperparameterTuningJobMaxTrialCount                  The desired total number of Trials.
 * @param int    $hyperparameterTuningJobParallelTrialCount             The desired number of Trials to run in parallel.
 */
function create_hyperparameter_tuning_job_sample(
    string $formattedParent,
    string $hyperparameterTuningJobDisplayName,
    string $hyperparameterTuningJobStudySpecMetricsMetricId,
    int $hyperparameterTuningJobStudySpecMetricsGoal,
    string $hyperparameterTuningJobStudySpecParametersParameterId,
    int $hyperparameterTuningJobMaxTrialCount,
    int $hyperparameterTuningJobParallelTrialCount
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $metricSpec = (new MetricSpec())
        ->setMetricId($hyperparameterTuningJobStudySpecMetricsMetricId)
        ->setGoal($hyperparameterTuningJobStudySpecMetricsGoal);
    $hyperparameterTuningJobStudySpecMetrics = [$metricSpec,];
    $parameterSpec = (new ParameterSpec())
        ->setParameterId($hyperparameterTuningJobStudySpecParametersParameterId);
    $hyperparameterTuningJobStudySpecParameters = [$parameterSpec,];
    $hyperparameterTuningJobStudySpec = (new StudySpec())
        ->setMetrics($hyperparameterTuningJobStudySpecMetrics)
        ->setParameters($hyperparameterTuningJobStudySpecParameters);
    $hyperparameterTuningJobTrialJobSpecWorkerPoolSpecs = [new WorkerPoolSpec()];
    $hyperparameterTuningJobTrialJobSpec = (new CustomJobSpec())
        ->setWorkerPoolSpecs($hyperparameterTuningJobTrialJobSpecWorkerPoolSpecs);
    $hyperparameterTuningJob = (new HyperparameterTuningJob())
        ->setDisplayName($hyperparameterTuningJobDisplayName)
        ->setStudySpec($hyperparameterTuningJobStudySpec)
        ->setMaxTrialCount($hyperparameterTuningJobMaxTrialCount)
        ->setParallelTrialCount($hyperparameterTuningJobParallelTrialCount)
        ->setTrialJobSpec($hyperparameterTuningJobTrialJobSpec);

    // Call the API and handle any network failures.
    try {
        /** @var HyperparameterTuningJob $response */
        $response = $jobServiceClient->createHyperparameterTuningJob(
            $formattedParent,
            $hyperparameterTuningJob
        );
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
    $formattedParent = JobServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $hyperparameterTuningJobDisplayName = '[DISPLAY_NAME]';
    $hyperparameterTuningJobStudySpecMetricsMetricId = '[METRIC_ID]';
    $hyperparameterTuningJobStudySpecMetricsGoal = GoalType::GOAL_TYPE_UNSPECIFIED;
    $hyperparameterTuningJobStudySpecParametersParameterId = '[PARAMETER_ID]';
    $hyperparameterTuningJobMaxTrialCount = 0;
    $hyperparameterTuningJobParallelTrialCount = 0;

    create_hyperparameter_tuning_job_sample(
        $formattedParent,
        $hyperparameterTuningJobDisplayName,
        $hyperparameterTuningJobStudySpecMetricsMetricId,
        $hyperparameterTuningJobStudySpecMetricsGoal,
        $hyperparameterTuningJobStudySpecParametersParameterId,
        $hyperparameterTuningJobMaxTrialCount,
        $hyperparameterTuningJobParallelTrialCount
    );
}
// [END aiplatform_v1_generated_JobService_CreateHyperparameterTuningJob_sync]
