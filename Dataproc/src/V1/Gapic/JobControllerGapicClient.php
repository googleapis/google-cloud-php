<?php
/*
 * Copyright 2017 Google LLC
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
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/dataproc/v1/jobs.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Dataproc\V1\CancelJobRequest;
use Google\Cloud\Dataproc\V1\DeleteJobRequest;
use Google\Cloud\Dataproc\V1\GetJobRequest;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\ListJobsRequest;
use Google\Cloud\Dataproc\V1\ListJobsResponse;
use Google\Cloud\Dataproc\V1\SubmitJobRequest;
use Google\Cloud\Dataproc\V1\UpdateJobRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The JobController provides methods to manage jobs.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $jobControllerClient = new JobControllerClient();
 * try {
 *     $projectId = '';
 *     $region = '';
 *     $job = new Job();
 *     $response = $jobControllerClient->submitJob($projectId, $region, $job);
 * } finally {
 *     $jobControllerClient->close();
 * }
 * ```
 *
 * @experimental
 */
class JobControllerGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.dataproc.v1.JobController';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'dataproc.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/job_controller_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/job_controller_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/job_controller_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'dataproc.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any $serviceAddress
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Submits a job to a cluster.
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $job = new Job();
     *     $response = $jobControllerClient->submitJob($projectId, $region, $job);
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param Job    $job          Required. The job resource.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function submitJob($projectId, $region, $job, array $optionalArgs = [])
    {
        $request = new SubmitJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJob($job);

        return $this->startCall(
            'SubmitJob',
            Job::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the resource representation for a job in a project.
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $jobId = '';
     *     $response = $jobControllerClient->getJob($projectId, $region, $jobId);
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $jobId        Required. The job ID.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getJob($projectId, $region, $jobId, array $optionalArgs = [])
    {
        $request = new GetJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        return $this->startCall(
            'GetJob',
            Job::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists regions/{region}/jobs in a project.
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     // Iterate through all elements
     *     $pagedResponse = $jobControllerClient->listJobs($projectId, $region);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $jobControllerClient->listJobs($projectId, $region);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $clusterName
     *          Optional. If set, the returned jobs list includes only jobs that were
     *          submitted to the named cluster.
     *     @type int $jobStateMatcher
     *          Optional. Specifies enumerated categories of jobs to list.
     *          (default = match ALL jobs).
     *
     *          If `filter` is provided, `jobStateMatcher` will be ignored.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Dataproc\V1\ListJobsRequest_JobStateMatcher}
     *     @type string $filter
     *          Optional. A filter constraining the jobs to list. Filters are
     *          case-sensitive and have the following syntax:
     *
     *          [field = value] AND [field [= value]] ...
     *
     *          where **field** is `status.state` or `labels.[KEY]`, and `[KEY]` is a label
     *          key. **value** can be `*` to match all values.
     *          `status.state` can be either `ACTIVE` or `NON_ACTIVE`.
     *          Only the logical `AND` operator is supported; space-separated items are
     *          treated as having an implicit `AND` operator.
     *
     *          Example filter:
     *
     *          status.state = ACTIVE AND labels.env = staging AND labels.starred = *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listJobs($projectId, $region, array $optionalArgs = [])
    {
        $request = new ListJobsRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['clusterName'])) {
            $request->setClusterName($optionalArgs['clusterName']);
        }
        if (isset($optionalArgs['jobStateMatcher'])) {
            $request->setJobStateMatcher($optionalArgs['jobStateMatcher']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }

        return $this->getPagedListResponse(
            'ListJobs',
            $optionalArgs,
            ListJobsResponse::class,
            $request
        );
    }

    /**
     * Updates a job in a project.
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $jobId = '';
     *     $job = new Job();
     *     $updateMask = new FieldMask();
     *     $response = $jobControllerClient->updateJob($projectId, $region, $jobId, $job, $updateMask);
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string    $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                                belongs to.
     * @param string    $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string    $jobId        Required. The job ID.
     * @param Job       $job          Required. The changes to the job.
     * @param FieldMask $updateMask   Required. Specifies the path, relative to <code>Job</code>, of
     *                                the field to update. For example, to update the labels of a Job the
     *                                <code>update_mask</code> parameter would be specified as
     *                                <code>labels</code>, and the `PATCH` request body would specify the new
     *                                value. <strong>Note:</strong> Currently, <code>labels</code> is the only
     *                                field that can be updated.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateJob($projectId, $region, $jobId, $job, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);
        $request->setJob($job);
        $request->setUpdateMask($updateMask);

        return $this->startCall(
            'UpdateJob',
            Job::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Starts a job cancellation request. To access the job resource
     * after cancellation, call
     * [regions/{region}/jobs.list](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/list) or
     * [regions/{region}/jobs.get](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/get).
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $jobId = '';
     *     $response = $jobControllerClient->cancelJob($projectId, $region, $jobId);
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $jobId        Required. The job ID.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function cancelJob($projectId, $region, $jobId, array $optionalArgs = [])
    {
        $request = new CancelJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        return $this->startCall(
            'CancelJob',
            Job::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes the job from the project. If the job is active, the delete fails,
     * and the response returns `FAILED_PRECONDITION`.
     *
     * Sample code:
     * ```
     * $jobControllerClient = new JobControllerClient();
     * try {
     *     $projectId = '';
     *     $region = '';
     *     $jobId = '';
     *     $jobControllerClient->deleteJob($projectId, $region, $jobId);
     * } finally {
     *     $jobControllerClient->close();
     * }
     * ```
     *
     * @param string $projectId    Required. The ID of the Google Cloud Platform project that the job
     *                             belongs to.
     * @param string $region       Required. The Cloud Dataproc region in which to handle the request.
     * @param string $jobId        Required. The job ID.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteJob($projectId, $region, $jobId, array $optionalArgs = [])
    {
        $request = new DeleteJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        return $this->startCall(
            'DeleteJob',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
