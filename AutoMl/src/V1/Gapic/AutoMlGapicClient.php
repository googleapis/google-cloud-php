<?php
/*
 * Copyright 2019 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/cloud/automl/v1/service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\AutoMl\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\AutoMl\V1\CreateDatasetRequest;
use Google\Cloud\AutoMl\V1\CreateModelRequest;
use Google\Cloud\AutoMl\V1\Dataset;
use Google\Cloud\AutoMl\V1\DeleteDatasetRequest;
use Google\Cloud\AutoMl\V1\DeleteModelRequest;
use Google\Cloud\AutoMl\V1\ExportDataRequest;
use Google\Cloud\AutoMl\V1\GetDatasetRequest;
use Google\Cloud\AutoMl\V1\GetModelEvaluationRequest;
use Google\Cloud\AutoMl\V1\GetModelRequest;
use Google\Cloud\AutoMl\V1\ImportDataRequest;
use Google\Cloud\AutoMl\V1\InputConfig;
use Google\Cloud\AutoMl\V1\ListDatasetsRequest;
use Google\Cloud\AutoMl\V1\ListDatasetsResponse;
use Google\Cloud\AutoMl\V1\ListModelEvaluationsRequest;
use Google\Cloud\AutoMl\V1\ListModelEvaluationsResponse;
use Google\Cloud\AutoMl\V1\ListModelsRequest;
use Google\Cloud\AutoMl\V1\ListModelsResponse;
use Google\Cloud\AutoMl\V1\Model;
use Google\Cloud\AutoMl\V1\ModelEvaluation;
use Google\Cloud\AutoMl\V1\OutputConfig;
use Google\Cloud\AutoMl\V1\UpdateDatasetRequest;
use Google\Cloud\AutoMl\V1\UpdateModelRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;

/**
 * Service Description: AutoML Server API.
 *
 * The resource names are assigned by the server.
 * The server never reuses names that it has created after the resources with
 * those names are deleted.
 *
 * An ID of a resource is the last element of the item's resource name. For
 * `projects/{project_id}/locations/{location_id}/datasets/{dataset_id}`, then
 * the id for the item is `{dataset_id}`.
 *
 * Currently the only supported `location_id` is "us-central1".
 *
 * On any input that is documented to expect a string parameter in
 * snake_case or kebab-case, either of those cases is accepted.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
 * try {
 *     $formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
 *     $dataset = new Google\Cloud\AutoMl\V1\Dataset();
 *     $operationResponse = $autoMlClient->createDataset($formattedParent, $dataset);
 *     $operationResponse->pollUntilComplete();
 *     if ($operationResponse->operationSucceeded()) {
 *         $result = $operationResponse->getResult();
 *         // doSomethingWith($result)
 *     } else {
 *         $error = $operationResponse->getError();
 *         // handleError($error)
 *     }
 *
 *
 *     // Alternatively:
 *
 *     // start the operation, keep the operation name, and resume later
 *     $operationResponse = $autoMlClient->createDataset($formattedParent, $dataset);
 *     $operationName = $operationResponse->getName();
 *     // ... do other work
 *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'createDataset');
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
 *     $autoMlClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class AutoMlGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.automl.v1.AutoMl';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'automl.googleapis.com';

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
    private static $datasetNameTemplate;
    private static $locationNameTemplate;
    private static $modelNameTemplate;
    private static $modelEvaluationNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/auto_ml_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/auto_ml_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/auto_ml_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/auto_ml_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getDatasetNameTemplate()
    {
        if (null == self::$datasetNameTemplate) {
            self::$datasetNameTemplate = new PathTemplate('projects/{project}/locations/{location}/datasets/{dataset}');
        }

        return self::$datasetNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (null == self::$locationNameTemplate) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getModelNameTemplate()
    {
        if (null == self::$modelNameTemplate) {
            self::$modelNameTemplate = new PathTemplate('projects/{project}/locations/{location}/models/{model}');
        }

        return self::$modelNameTemplate;
    }

    private static function getModelEvaluationNameTemplate()
    {
        if (null == self::$modelEvaluationNameTemplate) {
            self::$modelEvaluationNameTemplate = new PathTemplate('projects/{project}/locations/{location}/models/{model}/modelEvaluations/{model_evaluation}');
        }

        return self::$modelEvaluationNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'dataset' => self::getDatasetNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'model' => self::getModelNameTemplate(),
                'modelEvaluation' => self::getModelEvaluationNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a dataset resource.
     *
     * @param string $project
     * @param string $location
     * @param string $dataset
     *
     * @return string The formatted dataset resource.
     * @experimental
     */
    public static function datasetName($project, $location, $dataset)
    {
        return self::getDatasetNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'dataset' => $dataset,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $project
     * @param string $location
     *
     * @return string The formatted location resource.
     * @experimental
     */
    public static function locationName($project, $location)
    {
        return self::getLocationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a model resource.
     *
     * @param string $project
     * @param string $location
     * @param string $model
     *
     * @return string The formatted model resource.
     * @experimental
     */
    public static function modelName($project, $location, $model)
    {
        return self::getModelNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'model' => $model,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a model_evaluation resource.
     *
     * @param string $project
     * @param string $location
     * @param string $model
     * @param string $modelEvaluation
     *
     * @return string The formatted model_evaluation resource.
     * @experimental
     */
    public static function modelEvaluationName($project, $location, $model, $modelEvaluation)
    {
        return self::getModelEvaluationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'model' => $model,
            'model_evaluation' => $modelEvaluation,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - dataset: projects/{project}/locations/{location}/datasets/{dataset}
     * - location: projects/{project}/locations/{location}
     * - model: projects/{project}/locations/{location}/models/{model}
     * - modelEvaluation: projects/{project}/locations/{location}/models/{model}/modelEvaluations/{model_evaluation}.
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
     * @return OperationsClient
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
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
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
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'automl.googleapis.com:443'.
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
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Creates a dataset.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
     *     $dataset = new Google\Cloud\AutoMl\V1\Dataset();
     *     $operationResponse = $autoMlClient->createDataset($formattedParent, $dataset);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->createDataset($formattedParent, $dataset);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'createDataset');
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
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string  $parent       The resource name of the project to create the dataset for.
     * @param Dataset $dataset      The dataset to create.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createDataset($parent, $dataset, array $optionalArgs = [])
    {
        $request = new CreateDatasetRequest();
        $request->setParent($parent);
        $request->setDataset($dataset);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateDataset',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates a dataset.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $dataset = new Google\Cloud\AutoMl\V1\Dataset();
     *     $updateMask = new FieldMask();
     *     $response = $autoMlClient->updateDataset($dataset, $updateMask);
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param Dataset   $dataset      The dataset which replaces the resource on the server.
     * @param FieldMask $updateMask   Required. The update mask applies to the resource.
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
     * @return \Google\Cloud\AutoMl\V1\Dataset
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateDataset($dataset, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateDatasetRequest();
        $request->setDataset($dataset);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'dataset.name' => $request->getDataset()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateDataset',
            Dataset::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a dataset.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
     *     $response = $autoMlClient->getDataset($formattedName);
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the dataset to retrieve.
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
     * @return \Google\Cloud\AutoMl\V1\Dataset
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDataset($name, array $optionalArgs = [])
    {
        $request = new GetDatasetRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetDataset',
            Dataset::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists datasets in a project.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $autoMlClient->listDatasets($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $autoMlClient->listDatasets($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $parent       The resource name of the project from which to list datasets.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          An expression for filtering the results of the request.
     *
     *            * `dataset_metadata` - for existence of the case (e.g.
     *                      image_classification_dataset_metadata:*).
     *          Some examples of using the filter are:
     *
     *            * `translation_dataset_metadata:*` --> The dataset has
     *                                                   translation_dataset_metadata.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
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
    public function listDatasets($parent, array $optionalArgs = [])
    {
        $request = new ListDatasetsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListDatasets',
            $optionalArgs,
            ListDatasetsResponse::class,
            $request
        );
    }

    /**
     * Deletes a dataset and all of its contents.
     * Returns empty response in the
     * [response][google.longrunning.Operation.response] field when it completes,
     * and `delete_details` in the
     * [metadata][google.longrunning.Operation.metadata] field.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
     *     $operationResponse = $autoMlClient->deleteDataset($formattedName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->deleteDataset($formattedName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'deleteDataset');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the dataset to delete.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteDataset($name, array $optionalArgs = [])
    {
        $request = new DeleteDatasetRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'DeleteDataset',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Imports data into a dataset.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
     *     $inputConfig = new InputConfig();
     *     $operationResponse = $autoMlClient->importData($formattedName, $inputConfig);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->importData($formattedName, $inputConfig);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'importData');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string      $name         Required. Dataset name. Dataset must already exist. All imported
     *                                  annotations and examples will be added.
     * @param InputConfig $inputConfig  Required. The desired input location and its domain specific semantics,
     *                                  if any.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function importData($name, $inputConfig, array $optionalArgs = [])
    {
        $request = new ImportDataRequest();
        $request->setName($name);
        $request->setInputConfig($inputConfig);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ImportData',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Exports dataset's data to the provided output location.
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]');
     *     $outputConfig = new OutputConfig();
     *     $operationResponse = $autoMlClient->exportData($formattedName, $outputConfig);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->exportData($formattedName, $outputConfig);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'exportData');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string       $name         Required. The resource name of the dataset.
     * @param OutputConfig $outputConfig Required. The desired output location.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function exportData($name, $outputConfig, array $optionalArgs = [])
    {
        $request = new ExportDataRequest();
        $request->setName($name);
        $request->setOutputConfig($outputConfig);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'ExportData',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Creates a model.
     * Returns a Model in the [response][google.longrunning.Operation.response]
     * field when it completes.
     * When you create a model, several model evaluations are created for it:
     * a global evaluation, and one evaluation for each annotation spec.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
     *     $model = new Model();
     *     $operationResponse = $autoMlClient->createModel($formattedParent, $model);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->createModel($formattedParent, $model);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'createModel');
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
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the parent project where the model is being created.
     * @param Model  $model        The model to create.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createModel($parent, $model, array $optionalArgs = [])
    {
        $request = new CreateModelRequest();
        $request->setParent($parent);
        $request->setModel($model);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateModel',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets a model.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->modelName('[PROJECT]', '[LOCATION]', '[MODEL]');
     *     $response = $autoMlClient->getModel($formattedName);
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the model.
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
     * @return \Google\Cloud\AutoMl\V1\Model
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getModel($name, array $optionalArgs = [])
    {
        $request = new GetModelRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetModel',
            Model::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a model.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $model = new Model();
     *     $updateMask = new FieldMask();
     *     $response = $autoMlClient->updateModel($model, $updateMask);
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param Model     $model        The model which replaces the resource on the server.
     * @param FieldMask $updateMask   Required. The update mask applies to the resource.
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
     * @return \Google\Cloud\AutoMl\V1\Model
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateModel($model, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateModelRequest();
        $request->setModel($model);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'model.name' => $request->getModel()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateModel',
            Model::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists models.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedParent = $autoMlClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $autoMlClient->listModels($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $autoMlClient->listModels($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the project, from which to list the models.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          An expression for filtering the results of the request.
     *
     *            * `model_metadata` - for existence of the case (e.g.
     *                      video_classification_model_metadata:*).
     *            * `dataset_id` - for = or !=. Some examples of using the filter are:
     *
     *            * `image_classification_model_metadata:*` --> The model has
     *                                                 image_classification_model_metadata.
     *            * `dataset_id=5` --> The model was created from a dataset with ID 5.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
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
    public function listModels($parent, array $optionalArgs = [])
    {
        $request = new ListModelsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListModels',
            $optionalArgs,
            ListModelsResponse::class,
            $request
        );
    }

    /**
     * Deletes a model.
     * Returns `google.protobuf.Empty` in the
     * [response][google.longrunning.Operation.response] field when it completes,
     * and `delete_details` in the
     * [metadata][google.longrunning.Operation.metadata] field.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->modelName('[PROJECT]', '[LOCATION]', '[MODEL]');
     *     $operationResponse = $autoMlClient->deleteModel($formattedName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         // operation succeeded and returns no value
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $autoMlClient->deleteModel($formattedName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $autoMlClient->resumeOperation($operationName, 'deleteModel');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the model being deleted.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteModel($name, array $optionalArgs = [])
    {
        $request = new DeleteModelRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'DeleteModel',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets a model evaluation.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedName = $autoMlClient->modelEvaluationName('[PROJECT]', '[LOCATION]', '[MODEL]', '[MODEL_EVALUATION]');
     *     $response = $autoMlClient->getModelEvaluation($formattedName);
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name for the model evaluation.
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
     * @return \Google\Cloud\AutoMl\V1\ModelEvaluation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getModelEvaluation($name, array $optionalArgs = [])
    {
        $request = new GetModelEvaluationRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetModelEvaluation',
            ModelEvaluation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists model evaluations.
     *
     * Sample code:
     * ```
     * $autoMlClient = new Google\Cloud\AutoMl\V1\AutoMlClient();
     * try {
     *     $formattedParent = $autoMlClient->modelName('[PROJECT]', '[LOCATION]', '[MODEL]');
     *     $filter = '';
     *     // Iterate over pages of elements
     *     $pagedResponse = $autoMlClient->listModelEvaluations($formattedParent, $filter);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $autoMlClient->listModelEvaluations($formattedParent, $filter);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $autoMlClient->close();
     * }
     * ```
     *
     * @param string $parent Resource name of the model to list the model evaluations for.
     *                       If modelId is set as "-", this will list model evaluations from across all
     *                       models of the parent location.
     * @param string $filter An expression for filtering the results of the request.
     *
     *   * `annotation_spec_id` - for =, !=  or existence. See example below for
     *                          the last.
     *
     * Some examples of using the filter are:
     *
     *   * `annotation_spec_id!=4` --> The model evaluation was done for
     *                             annotation spec with ID different than 4.
     *   * `NOT annotation_spec_id:*` --> The model evaluation was done for
     *                                aggregate of all annotation specs.
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listModelEvaluations($parent, $filter, array $optionalArgs = [])
    {
        $request = new ListModelEvaluationsRequest();
        $request->setParent($parent);
        $request->setFilter($filter);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListModelEvaluations',
            $optionalArgs,
            ListModelEvaluationsResponse::class,
            $request
        );
    }
}
