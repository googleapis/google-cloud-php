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

// [START jobs_v4beta1_generated_JobService_BatchCreateJobs_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Talent\V4beta1\Job;
use Google\Cloud\Talent\V4beta1\JobOperationResult;
use Google\Cloud\Talent\V4beta1\JobServiceClient;
use Google\Rpc\Status;

/**
 * Begins executing a batch create jobs operation.
 *
 * @param string $formattedParent      The resource name of the tenant under which the job is created.
 *
 *                                     The format is "projects/{project_id}/tenants/{tenant_id}". For example,
 *                                     "projects/foo/tenant/bar". If tenant id is unspecified, a default tenant
 *                                     is created. For example, "projects/foo". Please see
 *                                     {@see JobServiceClient::projectName()} for help formatting this field.
 * @param string $formattedJobsCompany The resource name of the company listing the job.
 *
 *                                     The format is
 *                                     "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}". For
 *                                     example, "projects/foo/tenants/bar/companies/baz".
 *
 *                                     If tenant id is unspecified, the default tenant is used. For
 *                                     example, "projects/foo/companies/bar". Please see
 *                                     {@see JobServiceClient::companyName()} for help formatting this field.
 * @param string $jobsRequisitionId    The requisition ID, also referred to as the posting ID, is assigned by the
 *                                     client to identify a job. This field is intended to be used by clients
 *                                     for client identification and tracking of postings. A job isn't allowed
 *                                     to be created if there is another job with the same [company][google.cloud.talent.v4beta1.Job.name],
 *                                     [language_code][google.cloud.talent.v4beta1.Job.language_code] and [requisition_id][google.cloud.talent.v4beta1.Job.requisition_id].
 *
 *                                     The maximum number of allowed characters is 255.
 * @param string $jobsTitle            The title of the job, such as "Software Engineer"
 *
 *                                     The maximum number of allowed characters is 500.
 * @param string $jobsDescription      The description of the job, which typically includes a multi-paragraph
 *                                     description of the company and related information. Separate fields are
 *                                     provided on the job object for [responsibilities][google.cloud.talent.v4beta1.Job.responsibilities],
 *                                     [qualifications][google.cloud.talent.v4beta1.Job.qualifications], and other job characteristics. Use of
 *                                     these separate job fields is recommended.
 *
 *                                     This field accepts and sanitizes HTML input, and also accepts
 *                                     bold, italic, ordered list, and unordered list markup tags.
 *
 *                                     The maximum number of allowed characters is 100,000.
 */
function batch_create_jobs_sample(
    string $formattedParent,
    string $formattedJobsCompany,
    string $jobsRequisitionId,
    string $jobsTitle,
    string $jobsDescription
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $job = (new Job())
        ->setCompany($formattedJobsCompany)
        ->setRequisitionId($jobsRequisitionId)
        ->setTitle($jobsTitle)
        ->setDescription($jobsDescription);
    $jobs = [$job,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $jobServiceClient->batchCreateJobs($formattedParent, $jobs);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var JobOperationResult $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedJobsCompany = JobServiceClient::companyName('[PROJECT]', '[TENANT]', '[COMPANY]');
    $jobsRequisitionId = '[REQUISITION_ID]';
    $jobsTitle = '[TITLE]';
    $jobsDescription = '[DESCRIPTION]';

    batch_create_jobs_sample(
        $formattedParent,
        $formattedJobsCompany,
        $jobsRequisitionId,
        $jobsTitle,
        $jobsDescription
    );
}
// [END jobs_v4beta1_generated_JobService_BatchCreateJobs_sync]
