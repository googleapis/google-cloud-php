<?php
/*
 * Copyright 2017, Google Inc. All rights reserved.
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
 * https://github.com/google/googleapis/blob/master/google/privacy/dlp/v2beta1/dlp.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Dlp\V2beta1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\LongRunning\OperationsClient;
use Google\GAX\OperationResponse;
use Google\GAX\PathTemplate;
use Google\Privacy\Dlp\V2beta1\ContentItem;
use Google\Privacy\Dlp\V2beta1\CreateInspectOperationRequest;
use Google\Privacy\Dlp\V2beta1\DlpServiceGrpcClient;
use Google\Privacy\Dlp\V2beta1\InspectConfig;
use Google\Privacy\Dlp\V2beta1\InspectContentRequest;
use Google\Privacy\Dlp\V2beta1\ListInfoTypesRequest;
use Google\Privacy\Dlp\V2beta1\ListInspectFindingsRequest;
use Google\Privacy\Dlp\V2beta1\ListRootCategoriesRequest;
use Google\Privacy\Dlp\V2beta1\OutputStorageConfig;
use Google\Privacy\Dlp\V2beta1\RedactContentRequest;
use Google\Privacy\Dlp\V2beta1\RedactContentRequest_ImageRedactionConfig as ImageRedactionConfig;
use Google\Privacy\Dlp\V2beta1\RedactContentRequest_ReplaceConfig as ReplaceConfig;
use Google\Privacy\Dlp\V2beta1\StorageConfig;

/**
 * Service Description: The DLP API is a service that allows clients
 * to detect the presence of Personally Identifiable Information (PII) and other
 * privacy-sensitive data in user-supplied, unstructured data streams, like text
 * blocks or images.
 * The service also includes methods for sensitive data redaction and
 * scheduling of data scans on Google Cloud Platform based data sets.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $dlpServiceClient = new DlpServiceClient();
 *     $inspectConfig = new InspectConfig();
 *     $items = [];
 *     $response = $dlpServiceClient->inspectContent($inspectConfig, $items);
 * } finally {
 *     $dlpServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 *
 * @experimental
 */
class DlpServiceClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'dlp.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $resultNameTemplate;

    private $grpcCredentialsHelper;
    private $dlpServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a result resource.
     *
     * @param string $result
     *
     * @return string The formatted result resource.
     * @experimental
     */
    public static function formatResultName($result)
    {
        return self::getResultNameTemplate()->render([
            'result' => $result,
        ]);
    }

    /**
     * Parses the result from the given fully-qualified path which
     * represents a result resource.
     *
     * @param string $resultName The fully-qualified result resource.
     *
     * @return string The extracted result value.
     * @experimental
     */
    public static function parseResultFromResultName($resultName)
    {
        return self::getResultNameTemplate()->match($resultName)['result'];
    }

    private static function getResultNameTemplate()
    {
        if (self::$resultNameTemplate == null) {
            self::$resultNameTemplate = new PathTemplate('inspect/results/{result}');
        }

        return self::$resultNameTemplate;
    }

    private static function getLongRunningDescriptors()
    {
        return [
            'createInspectOperation' => [
                'operationReturnType' => '\Google\Privacy\Dlp\V2beta1\InspectOperationResult',
                'metadataReturnType' => '\Google\Privacy\Dlp\V2beta1\InspectOperationMetadata',
            ],
        ];
    }

    private static function getGapicVersion()
    {
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\GAX\LongRunning\OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return \Google\GAX\OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $lroDescriptors = self::getLongRunningDescriptors();
        if (!is_null($methodName) && array_key_exists($methodName, $lroDescriptors)) {
            $options = $lroDescriptors[$methodName];
        } else {
            $options = [];
        }
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dlp.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the DLP API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
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
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['timeoutMillis']);
            unset($operationsClientOptions['retryingOverride']);
            $this->operationsClient = new OperationsClient($operationsClientOptions);
        }

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'inspectContent' => $defaultDescriptors,
            'redactContent' => $defaultDescriptors,
            'createInspectOperation' => $defaultDescriptors,
            'listInspectFindings' => $defaultDescriptors,
            'listInfoTypes' => $defaultDescriptors,
            'listRootCategories' => $defaultDescriptors,
        ];
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/dlp_service_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.privacy.dlp.v2beta1.DlpService',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createDlpServiceStubFunction = function ($hostname, $opts) {
            return new DlpServiceGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createDlpServiceStubFunction', $options)) {
            $createDlpServiceStubFunction = $options['createDlpServiceStubFunction'];
        }
        $this->dlpServiceStub = $this->grpcCredentialsHelper->createStub(
            $createDlpServiceStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Finds potentially sensitive info in a list of strings.
     * This method has limits on input size, processing time, and output size.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $inspectConfig = new InspectConfig();
     *     $items = [];
     *     $response = $dlpServiceClient->inspectContent($inspectConfig, $items);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param InspectConfig $inspectConfig Configuration for the inspector.
     * @param ContentItem[] $items         The list of items to inspect. Items in a single request are
     *                                     considered "related" unless inspect_config.independent_inputs is true.
     *                                     Up to 100 are allowed per request.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Privacy\Dlp\V2beta1\InspectContentResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function inspectContent($inspectConfig, $items, $optionalArgs = [])
    {
        $request = new InspectContentRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setItems($items);

        $mergedSettings = $this->defaultCallSettings['inspectContent']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'InspectContent',
            $mergedSettings,
            $this->descriptors['inspectContent']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Redacts potentially sensitive info from a list of strings.
     * This method has limits on input size, processing time, and output size.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $inspectConfig = new InspectConfig();
     *     $items = [];
     *     $replaceConfigs = [];
     *     $response = $dlpServiceClient->redactContent($inspectConfig, $items, $replaceConfigs);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param InspectConfig   $inspectConfig  Configuration for the inspector.
     * @param ContentItem[]   $items          The list of items to inspect. Up to 100 are allowed per request.
     * @param ReplaceConfig[] $replaceConfigs The strings to replace findings text findings with. Must specify at least
     *                                        one of these or one ImageRedactionConfig if redacting images.
     * @param array           $optionalArgs   {
     *                                        Optional.
     *
     *     @type ImageRedactionConfig[] $imageRedactionConfigs
     *          The configuration for specifying what content to redact from images.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Privacy\Dlp\V2beta1\RedactContentResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function redactContent($inspectConfig, $items, $replaceConfigs, $optionalArgs = [])
    {
        $request = new RedactContentRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setItems($items);
        $request->setReplaceConfigs($replaceConfigs);
        if (isset($optionalArgs['imageRedactionConfigs'])) {
            $request->setImageRedactionConfigs($optionalArgs['imageRedactionConfigs']);
        }

        $mergedSettings = $this->defaultCallSettings['redactContent']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'RedactContent',
            $mergedSettings,
            $this->descriptors['redactContent']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Schedules a job scanning content in a Google Cloud Platform data
     * repository.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $inspectConfig = new InspectConfig();
     *     $storageConfig = new StorageConfig();
     *     $outputConfig = new OutputStorageConfig();
     *     $operationResponse = $dlpServiceClient->createInspectOperation($inspectConfig, $storageConfig, $outputConfig);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $dlpServiceClient->createInspectOperation($inspectConfig, $storageConfig, $outputConfig);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $dlpServiceClient->resumeOperation($operationName, 'createInspectOperation');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param InspectConfig       $inspectConfig Configuration for the inspector.
     * @param StorageConfig       $storageConfig Specification of the data set to process.
     * @param OutputStorageConfig $outputConfig  Optional location to store findings. The bucket must already exist and
     *                                           the Google APIs service account for DLP must have write permission to
     *                                           write to the given bucket.
     *                                           <p>Results are split over multiple csv files with each file name matching
     *                                           the pattern "[operation_id]_[count].csv", for example
     *                                           `3094877188788974909_1.csv`. The `operation_id` matches the
     *                                           identifier for the Operation, and the `count` is a counter used for
     *                                           tracking the number of files written. <p>The CSV file(s) contain the
     *                                           following columns regardless of storage type scanned: <li>id <li>info_type
     *                                           <li>likelihood <li>byte size of finding <li>quote <li>time_stamp<br/>
     *                                           <p>For Cloud Storage the next columns are: <li>file_path
     *                                           <li>start_offset<br/>
     *                                           <p>For Cloud Datastore the next columns are: <li>project_id
     *                                           <li>namespace_id <li>path <li>column_name <li>offset
     * @param array               $optionalArgs  {
     *                                           Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Longrunning\Operation
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createInspectOperation($inspectConfig, $storageConfig, $outputConfig, $optionalArgs = [])
    {
        $request = new CreateInspectOperationRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setStorageConfig($storageConfig);
        $request->setOutputConfig($outputConfig);

        $mergedSettings = $this->defaultCallSettings['createInspectOperation']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'CreateInspectOperation',
            $mergedSettings,
            $this->descriptors['createInspectOperation']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns list of results for given inspect operation result set id.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $formattedName = DlpServiceClient::formatResultName("[RESULT]");
     *     $response = $dlpServiceClient->listInspectFindings($formattedName);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Identifier of the results set returned as metadata of
     *                             the longrunning operation created by a call to CreateInspectOperation.
     *                             Should be in the format of `inspect/results/{id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          Maximum number of results to return.
     *          If 0, the implementation selects a reasonable value.
     *     @type string $pageToken
     *          The value returned by the last `ListInspectFindingsResponse`; indicates
     *          that this is a continuation of a prior `ListInspectFindings` call, and that
     *          the system should return the next page of data.
     *     @type string $filter
     *          Restricts findings to items that match. Supports info_type and likelihood.
     *          <p>Examples:<br/>
     *          <li>info_type=EMAIL_ADDRESS
     *          <li>info_type=PHONE_NUMBER,EMAIL_ADDRESS
     *          <li>likelihood=VERY_LIKELY
     *          <li>likelihood=VERY_LIKELY,LIKELY
     *          <li>info_type=EMAIL_ADDRESS,likelihood=VERY_LIKELY,LIKELY
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Privacy\Dlp\V2beta1\ListInspectFindingsResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listInspectFindings($name, $optionalArgs = [])
    {
        $request = new ListInspectFindingsRequest();
        $request->setName($name);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }

        $mergedSettings = $this->defaultCallSettings['listInspectFindings']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'ListInspectFindings',
            $mergedSettings,
            $this->descriptors['listInspectFindings']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns sensitive information types for given category.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $category = "";
     *     $languageCode = "";
     *     $response = $dlpServiceClient->listInfoTypes($category, $languageCode);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param string $category     Category name as returned by ListRootCategories.
     * @param string $languageCode Optional BCP-47 language code for localized info type friendly
     *                             names. If omitted, or if localized strings are not available,
     *                             en-US strings will be returned.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Privacy\Dlp\V2beta1\ListInfoTypesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listInfoTypes($category, $languageCode, $optionalArgs = [])
    {
        $request = new ListInfoTypesRequest();
        $request->setCategory($category);
        $request->setLanguageCode($languageCode);

        $mergedSettings = $this->defaultCallSettings['listInfoTypes']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'ListInfoTypes',
            $mergedSettings,
            $this->descriptors['listInfoTypes']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns the list of root categories of sensitive information.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $languageCode = "";
     *     $response = $dlpServiceClient->listRootCategories($languageCode);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param string $languageCode Optional language code for localized friendly category names.
     *                             If omitted or if localized strings are not available,
     *                             en-US strings will be returned.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Privacy\Dlp\V2beta1\ListRootCategoriesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listRootCategories($languageCode, $optionalArgs = [])
    {
        $request = new ListRootCategoriesRequest();
        $request->setLanguageCode($languageCode);

        $mergedSettings = $this->defaultCallSettings['listRootCategories']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'ListRootCategories',
            $mergedSettings,
            $this->descriptors['listRootCategories']
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
        $this->dlpServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
