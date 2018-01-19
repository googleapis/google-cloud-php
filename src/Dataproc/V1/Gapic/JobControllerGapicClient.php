<?php
/*
 * Copyright 2018 Google LLC
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
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\CredentialsLoader;
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
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: The JobController provides methods to manage jobs.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/job_controller_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/job_controller_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/job_controller_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dataproc.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl().
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this option is unused.
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Google Cloud Dataproc API.
     *     @type string $clientConfigPath
     *           Path to a JSON file containing client method configuration, including retry settings.
     *           Specify this setting to specify the retry behavior of all methods on the client.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder. The retry settings provided in this option can be overridden
     *           by settings in $retryingOverride
     *     @type array $retryingOverride
     *           An associative array in which the keys are method names (e.g. 'createFoo'), and
     *           the values are retry settings to use for that method. The retry settings for each
     *           method can be a {@see Google\ApiCore\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\ApiCore\RetrySettings}
     *           for example usage. Passing a value of null is equivalent to a value of
     *           ['retriesEnabled' => false]. Retry settings provided in this setting override the
     *           settings in $clientConfigPath.
     *     @type callable $authHttpHandler A handler used to deliver PSR-7 requests specifically
     *           for authentication. Should match a signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $this->setClientOptions($options + self::getClientDefaults());
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
    public function submitJob($projectId, $region, $job, $optionalArgs = [])
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
    public function getJob($projectId, $region, $jobId, $optionalArgs = [])
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
    public function listJobs($projectId, $region, $optionalArgs = [])
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
    public function updateJob($projectId, $region, $jobId, $job, $updateMask, $optionalArgs = [])
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
    public function cancelJob($projectId, $region, $jobId, $optionalArgs = [])
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
    public function deleteJob($projectId, $region, $jobId, $optionalArgs = [])
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
