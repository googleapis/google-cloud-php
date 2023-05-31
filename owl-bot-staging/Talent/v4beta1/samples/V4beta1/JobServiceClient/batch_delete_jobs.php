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

// [START jobs_v4beta1_generated_JobService_BatchDeleteJobs_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Talent\V4beta1\JobServiceClient;

/**
 * Deletes a list of [Job][google.cloud.talent.v4beta1.Job]s by filter.
 *
 * @param string $formattedParent The resource name of the tenant under which the job is created.
 *
 *                                The format is "projects/{project_id}/tenants/{tenant_id}". For example,
 *                                "projects/foo/tenant/bar". If tenant id is unspecified, a default tenant
 *                                is created. For example, "projects/foo". Please see
 *                                {@see JobServiceClient::projectName()} for help formatting this field.
 * @param string $filter          The filter string specifies the jobs to be deleted.
 *
 *                                Supported operator: =, AND
 *
 *                                The fields eligible for filtering are:
 *
 *                                * `companyName` (Required)
 *                                * `requisitionId` (Required)
 *
 *                                Sample Query: companyName = "projects/foo/companies/bar" AND
 *                                requisitionId = "req-1"
 */
function batch_delete_jobs_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Call the API and handle any network failures.
    try {
        $jobServiceClient->batchDeleteJobs($formattedParent, $filter);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedParent = JobServiceClient::projectName('[PROJECT]');
    $filter = '[FILTER]';

    batch_delete_jobs_sample($formattedParent, $filter);
}
// [END jobs_v4beta1_generated_JobService_BatchDeleteJobs_sync]
