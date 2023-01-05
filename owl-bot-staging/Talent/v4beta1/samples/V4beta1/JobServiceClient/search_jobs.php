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

// [START jobs_v4beta1_generated_JobService_SearchJobs_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Talent\V4beta1\JobServiceClient;
use Google\Cloud\Talent\V4beta1\RequestMetadata;
use Google\Cloud\Talent\V4beta1\SearchJobsResponse\MatchingJob;

/**
 * Searches for jobs using the provided [SearchJobsRequest][google.cloud.talent.v4beta1.SearchJobsRequest].
 *
 * This call constrains the [visibility][google.cloud.talent.v4beta1.Job.visibility] of jobs
 * present in the database, and only returns jobs that the caller has
 * permission to search against.
 *
 * @param string $formattedParent The resource name of the tenant to search within.
 *
 *                                The format is "projects/{project_id}/tenants/{tenant_id}". For example,
 *                                "projects/foo/tenant/bar". If tenant id is unspecified, a default tenant
 *                                is created. For example, "projects/foo". Please see
 *                                {@see JobServiceClient::projectName()} for help formatting this field.
 */
function search_jobs_sample(string $formattedParent): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestMetadata = new RequestMetadata();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $jobServiceClient->searchJobs($formattedParent, $requestMetadata);

        /** @var MatchingJob $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = JobServiceClient::projectName('[PROJECT]');

    search_jobs_sample($formattedParent);
}
// [END jobs_v4beta1_generated_JobService_SearchJobs_sync]
