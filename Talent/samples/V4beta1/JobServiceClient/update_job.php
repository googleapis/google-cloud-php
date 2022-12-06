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

// [START jobs_v4beta1_generated_JobService_UpdateJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Talent\V4beta1\Job;
use Google\Cloud\Talent\V4beta1\JobServiceClient;

/**
 * Updates specified job.
 *
 * Typically, updated contents become visible in search results within 10
 * seconds, but it may take up to 5 minutes.
 *
 * @param string $formattedJobCompany The resource name of the company listing the job.
 *
 *                                    The format is
 *                                    "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}". For
 *                                    example, "projects/foo/tenants/bar/companies/baz".
 *
 *                                    If tenant id is unspecified, the default tenant is used. For
 *                                    example, "projects/foo/companies/bar". Please see
 *                                    {@see JobServiceClient::companyName()} for help formatting this field.
 * @param string $jobRequisitionId    The requisition ID, also referred to as the posting ID, is assigned by the
 *                                    client to identify a job. This field is intended to be used by clients
 *                                    for client identification and tracking of postings. A job isn't allowed
 *                                    to be created if there is another job with the same [company][google.cloud.talent.v4beta1.Job.name],
 *                                    [language_code][google.cloud.talent.v4beta1.Job.language_code] and [requisition_id][google.cloud.talent.v4beta1.Job.requisition_id].
 *
 *                                    The maximum number of allowed characters is 255.
 * @param string $jobTitle            The title of the job, such as "Software Engineer"
 *
 *                                    The maximum number of allowed characters is 500.
 * @param string $jobDescription      The description of the job, which typically includes a multi-paragraph
 *                                    description of the company and related information. Separate fields are
 *                                    provided on the job object for [responsibilities][google.cloud.talent.v4beta1.Job.responsibilities],
 *                                    [qualifications][google.cloud.talent.v4beta1.Job.qualifications], and other job characteristics. Use of
 *                                    these separate job fields is recommended.
 *
 *                                    This field accepts and sanitizes HTML input, and also accepts
 *                                    bold, italic, ordered list, and unordered list markup tags.
 *
 *                                    The maximum number of allowed characters is 100,000.
 */
function update_job_sample(
    string $formattedJobCompany,
    string $jobRequisitionId,
    string $jobTitle,
    string $jobDescription
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $job = (new Job())
        ->setCompany($formattedJobCompany)
        ->setRequisitionId($jobRequisitionId)
        ->setTitle($jobTitle)
        ->setDescription($jobDescription);

    // Call the API and handle any network failures.
    try {
        /** @var Job $response */
        $response = $jobServiceClient->updateJob($job);
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
    $formattedJobCompany = JobServiceClient::companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
    $jobRequisitionId = '[REQUISITION_ID]';
    $jobTitle = '[TITLE]';
    $jobDescription = '[DESCRIPTION]';

    update_job_sample($formattedJobCompany, $jobRequisitionId, $jobTitle, $jobDescription);
}
// [END jobs_v4beta1_generated_JobService_UpdateJob_sync]
