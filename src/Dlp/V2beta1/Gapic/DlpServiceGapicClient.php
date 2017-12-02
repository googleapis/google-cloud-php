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
 * https://github.com/google/googleapis/blob/master/google/privacy/dlp/v2beta1/dlp.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Dlp\V2beta1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Dlp\V2beta1\AnalyzeDataSourceRiskRequest;
use Google\Cloud\Dlp\V2beta1\BigQueryTable;
use Google\Cloud\Dlp\V2beta1\ContentItem;
use Google\Cloud\Dlp\V2beta1\CreateInspectOperationRequest;
use Google\Cloud\Dlp\V2beta1\DeidentifyConfig;
use Google\Cloud\Dlp\V2beta1\DeidentifyContentRequest;
use Google\Cloud\Dlp\V2beta1\DlpServiceGrpcClient;
use Google\Cloud\Dlp\V2beta1\InspectConfig;
use Google\Cloud\Dlp\V2beta1\InspectContentRequest;
use Google\Cloud\Dlp\V2beta1\ListInfoTypesRequest;
use Google\Cloud\Dlp\V2beta1\ListInspectFindingsRequest;
use Google\Cloud\Dlp\V2beta1\ListRootCategoriesRequest;
use Google\Cloud\Dlp\V2beta1\OperationConfig;
use Google\Cloud\Dlp\V2beta1\OutputStorageConfig;
use Google\Cloud\Dlp\V2beta1\PrivacyMetric;
use Google\Cloud\Dlp\V2beta1\RedactContentRequest;
use Google\Cloud\Dlp\V2beta1\RedactContentRequest_ImageRedactionConfig as ImageRedactionConfig;
use Google\Cloud\Dlp\V2beta1\RedactContentRequest_ReplaceConfig as ReplaceConfig;
use Google\Cloud\Dlp\V2beta1\StorageConfig;
use Google\Cloud\Version;

/**
 * Service Description: The DLP API is a service that allows clients
 * to detect the presence of Personally Identifiable Information (PII) and other
 * privacy-sensitive data in user-supplied, unstructured data streams, like text
 * blocks or images.
 * The service also includes methods for sensitive data redaction and
 * scheduling of data scans on Google Cloud Platform based data sets.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $dlpServiceClient = new DlpServiceClient();
 *     $name = 'EMAIL_ADDRESS';
 *     $infoTypesElement = new InfoType();
 *     $infoTypesElement->setName($name);
 *     $infoTypes = [$infoTypesElement];
 *     $inspectConfig = new InspectConfig();
 *     $inspectConfig->setInfoTypes($infoTypes);
 *     $type = 'text/plain';
 *     $value = 'My email is example@example.com.';
 *     $itemsElement = new ContentItem();
 *     $itemsElement->setType($type);
 *     $itemsElement->setValue($value);
 *     $items = [$itemsElement];
 *     $response = $dlpServiceClient->inspectContent($inspectConfig, $items);
 * } finally {
 *     $dlpServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 */
class DlpServiceGapicClient
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
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $resultNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $dlpServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getResultNameTemplate()
    {
        if (self::$resultNameTemplate == null) {
            self::$resultNameTemplate = new PathTemplate('inspect/results/{result}');
        }

        return self::$resultNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'result' => self::getResultNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getLongRunningDescriptors()
    {
        return [
            'analyzeDataSourceRisk' => [
                'operationReturnType' => '\Google\Cloud\Dlp\V2beta1\RiskAnalysisOperationResult',
                'metadataReturnType' => '\Google\Cloud\Dlp\V2beta1\RiskAnalysisOperationMetadata',
            ],
            'createInspectOperation' => [
                'operationReturnType' => '\Google\Cloud\Dlp\V2beta1\InspectOperationResult',
                'metadataReturnType' => '\Google\Cloud\Dlp\V2beta1\InspectOperationMetadata',
            ],
        ];
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
     * Formats a string containing the fully-qualified path to represent
     * a result resource.
     *
     * @param string $result
     *
     * @return string The formatted result resource.
     * @experimental
     */
    public static function resultName($result)
    {
        return self::getResultNameTemplate()->render([
            'result' => $result,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - result: inspect/results/{result}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\ApiCore\LongRunning\OperationsClient
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
     * @return \Google\ApiCore\OperationResponse
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

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'dlp.googleapis.com'.
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
     *                          Defaults to the scopes for the DLP API.
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
            'clientConfigPath' => __DIR__.'/../resources/dlp_service_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['retryingOverride']);
            unset($operationsClientOptions['clientConfigPath']);
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
            'deidentifyContent' => $defaultDescriptors,
            'analyzeDataSourceRisk' => $defaultDescriptors,
            'createInspectOperation' => $defaultDescriptors,
            'listInspectFindings' => $defaultDescriptors,
            'listInfoTypes' => $defaultDescriptors,
            'listRootCategories' => $defaultDescriptors,
        ];
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.privacy.dlp.v2beta1.DlpService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createDlpServiceStubFunction = function ($hostname, $opts, $channel) {
            return new DlpServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createDlpServiceStubFunction', $options)) {
            $createDlpServiceStubFunction = $options['createDlpServiceStubFunction'];
        }
        $this->dlpServiceStub = $this->grpcCredentialsHelper->createStub($createDlpServiceStubFunction);
    }

    /**
     * Finds potentially sensitive info in a list of strings.
     * This method has limits on input size, processing time, and output size.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $name = 'EMAIL_ADDRESS';
     *     $infoTypesElement = new InfoType();
     *     $infoTypesElement->setName($name);
     *     $infoTypes = [$infoTypesElement];
     *     $inspectConfig = new InspectConfig();
     *     $inspectConfig->setInfoTypes($infoTypes);
     *     $type = 'text/plain';
     *     $value = 'My email is example@example.com.';
     *     $itemsElement = new ContentItem();
     *     $itemsElement->setType($type);
     *     $itemsElement->setValue($value);
     *     $items = [$itemsElement];
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\InspectContentResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function inspectContent($inspectConfig, $items, $optionalArgs = [])
    {
        $request = new InspectContentRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setItems($items);

        $defaultCallSettings = $this->defaultCallSettings['inspectContent'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $name = 'EMAIL_ADDRESS';
     *     $infoTypesElement = new InfoType();
     *     $infoTypesElement->setName($name);
     *     $infoTypes = [$infoTypesElement];
     *     $inspectConfig = new InspectConfig();
     *     $inspectConfig->setInfoTypes($infoTypes);
     *     $type = 'text/plain';
     *     $value = 'My email is example@example.com.';
     *     $itemsElement = new ContentItem();
     *     $itemsElement->setType($type);
     *     $itemsElement->setValue($value);
     *     $items = [$itemsElement];
     *     $response = $dlpServiceClient->redactContent($inspectConfig, $items);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param InspectConfig $inspectConfig Configuration for the inspector.
     * @param ContentItem[] $items         The list of items to inspect. Up to 100 are allowed per request.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type ReplaceConfig[] $replaceConfigs
     *          The strings to replace findings text findings with. Must specify at least
     *          one of these or one ImageRedactionConfig if redacting images.
     *     @type ImageRedactionConfig[] $imageRedactionConfigs
     *          The configuration for specifying what content to redact from images.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\RedactContentResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function redactContent($inspectConfig, $items, $optionalArgs = [])
    {
        $request = new RedactContentRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setItems($items);
        if (isset($optionalArgs['replaceConfigs'])) {
            $request->setReplaceConfigs($optionalArgs['replaceConfigs']);
        }
        if (isset($optionalArgs['imageRedactionConfigs'])) {
            $request->setImageRedactionConfigs($optionalArgs['imageRedactionConfigs']);
        }

        $defaultCallSettings = $this->defaultCallSettings['redactContent'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     * De-identifies potentially sensitive info from a list of strings.
     * This method has limits on input size and output size.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $deidentifyConfig = new DeidentifyConfig();
     *     $inspectConfig = new InspectConfig();
     *     $items = [];
     *     $response = $dlpServiceClient->deidentifyContent($deidentifyConfig, $inspectConfig, $items);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param DeidentifyConfig $deidentifyConfig Configuration for the de-identification of the list of content items.
     * @param InspectConfig    $inspectConfig    Configuration for the inspector.
     * @param ContentItem[]    $items            The list of items to inspect. Up to 100 are allowed per request.
     *                                           All items will be treated as text/*.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\DeidentifyContentResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deidentifyContent($deidentifyConfig, $inspectConfig, $items, $optionalArgs = [])
    {
        $request = new DeidentifyContentRequest();
        $request->setDeidentifyConfig($deidentifyConfig);
        $request->setInspectConfig($inspectConfig);
        $request->setItems($items);

        $defaultCallSettings = $this->defaultCallSettings['deidentifyContent'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'DeidentifyContent',
            $mergedSettings,
            $this->descriptors['deidentifyContent']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Schedules a job to compute risk analysis metrics over content in a Google
     * Cloud Platform repository.
     *
     * Sample code:
     * ```
     * try {
     *     $dlpServiceClient = new DlpServiceClient();
     *     $privacyMetric = new PrivacyMetric();
     *     $sourceTable = new BigQueryTable();
     *     $operationResponse = $dlpServiceClient->analyzeDataSourceRisk($privacyMetric, $sourceTable);
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
     *     $operationResponse = $dlpServiceClient->analyzeDataSourceRisk($privacyMetric, $sourceTable);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $dlpServiceClient->resumeOperation($operationName, 'analyzeDataSourceRisk');
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
     * @param PrivacyMetric $privacyMetric Privacy metric to compute.
     * @param BigQueryTable $sourceTable   Input dataset to compute metrics over.
     * @param array         $optionalArgs  {
     *                                     Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function analyzeDataSourceRisk($privacyMetric, $sourceTable, $optionalArgs = [])
    {
        $request = new AnalyzeDataSourceRiskRequest();
        $request->setPrivacyMetric($privacyMetric);
        $request->setSourceTable($sourceTable);

        $defaultCallSettings = $this->defaultCallSettings['analyzeDataSourceRisk'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->dlpServiceStub,
            'AnalyzeDataSourceRisk',
            $mergedSettings,
            $this->descriptors['analyzeDataSourceRisk']
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
     *     $name = 'EMAIL_ADDRESS';
     *     $infoTypesElement = new InfoType();
     *     $infoTypesElement->setName($name);
     *     $infoTypes = [$infoTypesElement];
     *     $inspectConfig = new InspectConfig();
     *     $inspectConfig->setInfoTypes($infoTypes);
     *     $url = 'gs://example_bucket/example_file.png';
     *     $fileSet = new FileSet();
     *     $fileSet->setUrl($url);
     *     $cloudStorageOptions = new CloudStorageOptions();
     *     $cloudStorageOptions->setFileSet($fileSet);
     *     $storageConfig = new StorageConfig();
     *     $storageConfig->setCloudStorageOptions($cloudStorageOptions);
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
     * @param OutputStorageConfig $outputConfig  Optional location to store findings.
     * @param array               $optionalArgs  {
     *                                           Optional.
     *
     *     @type OperationConfig $operationConfig
     *          Additional configuration settings for long running operations.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createInspectOperation($inspectConfig, $storageConfig, $outputConfig, $optionalArgs = [])
    {
        $request = new CreateInspectOperationRequest();
        $request->setInspectConfig($inspectConfig);
        $request->setStorageConfig($storageConfig);
        $request->setOutputConfig($outputConfig);
        if (isset($optionalArgs['operationConfig'])) {
            $request->setOperationConfig($optionalArgs['operationConfig']);
        }

        $defaultCallSettings = $this->defaultCallSettings['createInspectOperation'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $dlpServiceClient->resultName('[RESULT]');
     *     $response = $dlpServiceClient->listInspectFindings($formattedName);
     * } finally {
     *     $dlpServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Identifier of the results set returned as metadata of
     *                             the longrunning operation created by a call to InspectDataSource.
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
     *
     *          Examples:
     *
     *          - info_type=EMAIL_ADDRESS
     *          - info_type=PHONE_NUMBER,EMAIL_ADDRESS
     *          - likelihood=VERY_LIKELY
     *          - likelihood=VERY_LIKELY,LIKELY
     *          - info_type=EMAIL_ADDRESS,likelihood=VERY_LIKELY,LIKELY
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\ListInspectFindingsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
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

        $defaultCallSettings = $this->defaultCallSettings['listInspectFindings'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $category = 'PII';
     *     $languageCode = 'en';
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\ListInfoTypesResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listInfoTypes($category, $languageCode, $optionalArgs = [])
    {
        $request = new ListInfoTypesRequest();
        $request->setCategory($category);
        $request->setLanguageCode($languageCode);

        $defaultCallSettings = $this->defaultCallSettings['listInfoTypes'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $languageCode = 'en';
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Dlp\V2beta1\ListRootCategoriesResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listRootCategories($languageCode, $optionalArgs = [])
    {
        $request = new ListRootCategoriesRequest();
        $request->setLanguageCode($languageCode);

        $defaultCallSettings = $this->defaultCallSettings['listRootCategories'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
