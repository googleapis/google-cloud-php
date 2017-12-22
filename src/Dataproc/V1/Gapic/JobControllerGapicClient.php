<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
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
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Dataproc\V1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\Cloud\Dataproc\V1\CancelJobRequest;
use Google\Cloud\Dataproc\V1\DeleteJobRequest;
use Google\Cloud\Dataproc\V1\GetJobRequest;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\JobControllerGrpcClient;
use Google\Cloud\Dataproc\V1\ListJobsRequest;
use Google\Cloud\Dataproc\V1\ListJobsRequest_JobStateMatcher as JobStateMatcher;
use Google\Cloud\Dataproc\V1\SubmitJobRequest;
use Google\Cloud\Dataproc\V1\UpdateJobRequest;
use Google\Cloud\Version;
use Google\Protobuf\FieldMask;

/**
 * Service Description: The JobController provides methods to manage jobs.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $jobControllerClient = new JobControllerClient();
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

    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $jobControllerStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    private static function getPageStreamingDescriptors()
    {
        $listJobsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getJobs',
                ]);

        $pageStreamingDescriptors = [
            'listJobs' => $listJobsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getGapicVersion()
    {
        if (!self::$gapicVersionLoaded) {
            if (file_exists(__DIR__.'/../VERSION')) {
                self::$gapicVersion = trim(file_get_contents(__DIR__.'/../VERSION'));
            } elseif (class_exists(Version::class)) {
                self::$gapicVersion = Version::VERSION;
            }
            self::$gapicVersionLoaded = true;
        }

        return self::$gapicVersion;
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
     *     @type \Grpc\Channel $channel
     *           A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
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
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/job_controller_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'submitJob' => $defaultDescriptors,
            'getJob' => $defaultDescriptors,
            'listJobs' => $defaultDescriptors,
            'updateJob' => $defaultDescriptors,
            'cancelJob' => $defaultDescriptors,
            'deleteJob' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.dataproc.v1.JobController',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createJobControllerStubFunction = function ($hostname, $opts, $channel) {
            return new JobControllerGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createJobControllerStubFunction', $options)) {
            $createJobControllerStubFunction = $options['createJobControllerStubFunction'];
        }
        $this->jobControllerStub = $this->grpcCredentialsHelper->createStub($createJobControllerStubFunction);
    }

    /**
     * Submits a job to a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function submitJob($projectId, $region, $job, $optionalArgs = [])
    {
        $request = new SubmitJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJob($job);

        $defaultCallSettings = $this->defaultCallSettings['submitJob'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'SubmitJob',
            $mergedSettings,
            $this->descriptors['submitJob']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the resource representation for a job in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getJob($projectId, $region, $jobId, $optionalArgs = [])
    {
        $request = new GetJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        $defaultCallSettings = $this->defaultCallSettings['getJob'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'GetJob',
            $mergedSettings,
            $this->descriptors['getJob']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists regions/{region}/jobs in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['listJobs'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'ListJobs',
            $mergedSettings,
            $this->descriptors['listJobs']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates a job in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['updateJob'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'UpdateJob',
            $mergedSettings,
            $this->descriptors['updateJob']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Starts a job cancellation request. To access the job resource
     * after cancellation, call
     * [regions/{region}/jobs.list](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/list) or
     * [regions/{region}/jobs.get](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/get).
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dataproc\V1\Job
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function cancelJob($projectId, $region, $jobId, $optionalArgs = [])
    {
        $request = new CancelJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        $defaultCallSettings = $this->defaultCallSettings['cancelJob'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'CancelJob',
            $mergedSettings,
            $this->descriptors['cancelJob']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes the job from the project. If the job is active, the delete fails,
     * and the response returns `FAILED_PRECONDITION`.
     *
     * Sample code:
     * ```
     * try {
     *     $jobControllerClient = new JobControllerClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteJob($projectId, $region, $jobId, $optionalArgs = [])
    {
        $request = new DeleteJobRequest();
        $request->setProjectId($projectId);
        $request->setRegion($region);
        $request->setJobId($jobId);

        $defaultCallSettings = $this->defaultCallSettings['deleteJob'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->jobControllerStub,
            'DeleteJob',
            $mergedSettings,
            $this->descriptors['deleteJob']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->jobControllerStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
