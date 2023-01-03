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

// [START dataproc_v1_generated_AutoscalingPolicyService_UpdateAutoscalingPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\AutoscalingPolicy;
use Google\Cloud\Dataproc\V1\AutoscalingPolicyServiceClient;
use Google\Cloud\Dataproc\V1\BasicAutoscalingAlgorithm;
use Google\Cloud\Dataproc\V1\BasicYarnAutoscalingConfig;
use Google\Cloud\Dataproc\V1\InstanceGroupAutoscalingPolicyConfig;
use Google\Protobuf\Duration;

/**
 * Updates (replaces) autoscaling policy.
 *
 * Disabled check for update_mask, because all updates will be full
 * replacements.
 *
 * @param float $policyBasicAlgorithmYarnConfigScaleUpFactor   Fraction of average YARN pending memory in the last cooldown period
 *                                                             for which to add workers. A scale-up factor of 1.0 will result in scaling
 *                                                             up so that there is no pending memory remaining after the update (more
 *                                                             aggressive scaling). A scale-up factor closer to 0 will result in a smaller
 *                                                             magnitude of scaling up (less aggressive scaling).
 *                                                             See [How autoscaling
 *                                                             works](https://cloud.google.com/dataproc/docs/concepts/configuring-clusters/autoscaling#how_autoscaling_works)
 *                                                             for more information.
 *
 *                                                             Bounds: [0.0, 1.0].
 * @param float $policyBasicAlgorithmYarnConfigScaleDownFactor Fraction of average YARN pending memory in the last cooldown period
 *                                                             for which to remove workers. A scale-down factor of 1 will result in
 *                                                             scaling down so that there is no available memory remaining after the
 *                                                             update (more aggressive scaling). A scale-down factor of 0 disables
 *                                                             removing workers, which can be beneficial for autoscaling a single job.
 *                                                             See [How autoscaling
 *                                                             works](https://cloud.google.com/dataproc/docs/concepts/configuring-clusters/autoscaling#how_autoscaling_works)
 *                                                             for more information.
 *
 *                                                             Bounds: [0.0, 1.0].
 * @param int   $policyWorkerConfigMaxInstances                Maximum number of instances for this group. Required for primary
 *                                                             workers. Note that by default, clusters will not use secondary workers.
 *                                                             Required for secondary workers if the minimum secondary instances is set.
 *
 *                                                             Primary workers - Bounds: [min_instances, ).
 *                                                             Secondary workers - Bounds: [min_instances, ). Default: 0.
 */
function update_autoscaling_policy_sample(
    float $policyBasicAlgorithmYarnConfigScaleUpFactor,
    float $policyBasicAlgorithmYarnConfigScaleDownFactor,
    int $policyWorkerConfigMaxInstances
): void {
    // Create a client.
    $autoscalingPolicyServiceClient = new AutoscalingPolicyServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $policyBasicAlgorithmYarnConfigGracefulDecommissionTimeout = new Duration();
    $policyBasicAlgorithmYarnConfig = (new BasicYarnAutoscalingConfig())
        ->setGracefulDecommissionTimeout($policyBasicAlgorithmYarnConfigGracefulDecommissionTimeout)
        ->setScaleUpFactor($policyBasicAlgorithmYarnConfigScaleUpFactor)
        ->setScaleDownFactor($policyBasicAlgorithmYarnConfigScaleDownFactor);
    $policyBasicAlgorithm = (new BasicAutoscalingAlgorithm())
        ->setYarnConfig($policyBasicAlgorithmYarnConfig);
    $policyWorkerConfig = (new InstanceGroupAutoscalingPolicyConfig())
        ->setMaxInstances($policyWorkerConfigMaxInstances);
    $policy = (new AutoscalingPolicy())
        ->setBasicAlgorithm($policyBasicAlgorithm)
        ->setWorkerConfig($policyWorkerConfig);

    // Call the API and handle any network failures.
    try {
        /** @var AutoscalingPolicy $response */
        $response = $autoscalingPolicyServiceClient->updateAutoscalingPolicy($policy);
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
    $policyBasicAlgorithmYarnConfigScaleUpFactor = 0.0;
    $policyBasicAlgorithmYarnConfigScaleDownFactor = 0.0;
    $policyWorkerConfigMaxInstances = 0;

    update_autoscaling_policy_sample(
        $policyBasicAlgorithmYarnConfigScaleUpFactor,
        $policyBasicAlgorithmYarnConfigScaleDownFactor,
        $policyWorkerConfigMaxInstances
    );
}
// [END dataproc_v1_generated_AutoscalingPolicyService_UpdateAutoscalingPolicy_sync]
