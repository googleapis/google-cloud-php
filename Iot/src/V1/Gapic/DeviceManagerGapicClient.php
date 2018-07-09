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
 * https://github.com/google/googleapis/blob/master/google/cloud/iot/v1/device_manager.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Iot\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Iot\V1\CreateDeviceRegistryRequest;
use Google\Cloud\Iot\V1\CreateDeviceRequest;
use Google\Cloud\Iot\V1\DeleteDeviceRegistryRequest;
use Google\Cloud\Iot\V1\DeleteDeviceRequest;
use Google\Cloud\Iot\V1\Device;
use Google\Cloud\Iot\V1\DeviceConfig;
use Google\Cloud\Iot\V1\DeviceRegistry;
use Google\Cloud\Iot\V1\GetDeviceRegistryRequest;
use Google\Cloud\Iot\V1\GetDeviceRequest;
use Google\Cloud\Iot\V1\ListDeviceConfigVersionsRequest;
use Google\Cloud\Iot\V1\ListDeviceConfigVersionsResponse;
use Google\Cloud\Iot\V1\ListDeviceRegistriesRequest;
use Google\Cloud\Iot\V1\ListDeviceRegistriesResponse;
use Google\Cloud\Iot\V1\ListDeviceStatesRequest;
use Google\Cloud\Iot\V1\ListDeviceStatesResponse;
use Google\Cloud\Iot\V1\ListDevicesRequest;
use Google\Cloud\Iot\V1\ListDevicesResponse;
use Google\Cloud\Iot\V1\ModifyCloudToDeviceConfigRequest;
use Google\Cloud\Iot\V1\UpdateDeviceRegistryRequest;
use Google\Cloud\Iot\V1\UpdateDeviceRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Internet of things (IoT) service. Allows to manipulate device registry
 * instances and the registration of devices (Things) to the cloud.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $deviceManagerClient = new DeviceManagerClient();
 * try {
 *     $formattedParent = $deviceManagerClient->locationName('[PROJECT]', '[LOCATION]');
 *     $deviceRegistry = new DeviceRegistry();
 *     $response = $deviceManagerClient->createDeviceRegistry($formattedParent, $deviceRegistry);
 * } finally {
 *     $deviceManagerClient->close();
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
class DeviceManagerGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.iot.v1.DeviceManager';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'cloudiot.googleapis.com';

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
        'https://www.googleapis.com/auth/cloudiot',
    ];
    private static $locationNameTemplate;
    private static $registryNameTemplate;
    private static $deviceNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/device_manager_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/device_manager_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/device_manager_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getLocationNameTemplate()
    {
        if (self::$locationNameTemplate == null) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getRegistryNameTemplate()
    {
        if (self::$registryNameTemplate == null) {
            self::$registryNameTemplate = new PathTemplate('projects/{project}/locations/{location}/registries/{registry}');
        }

        return self::$registryNameTemplate;
    }

    private static function getDeviceNameTemplate()
    {
        if (self::$deviceNameTemplate == null) {
            self::$deviceNameTemplate = new PathTemplate('projects/{project}/locations/{location}/registries/{registry}/devices/{device}');
        }

        return self::$deviceNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'location' => self::getLocationNameTemplate(),
                'registry' => self::getRegistryNameTemplate(),
                'device' => self::getDeviceNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a registry resource.
     *
     * @param string $project
     * @param string $location
     * @param string $registry
     *
     * @return string The formatted registry resource.
     * @experimental
     */
    public static function registryName($project, $location, $registry)
    {
        return self::getRegistryNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'registry' => $registry,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a device resource.
     *
     * @param string $project
     * @param string $location
     * @param string $registry
     * @param string $device
     *
     * @return string The formatted device resource.
     * @experimental
     */
    public static function deviceName($project, $location, $registry, $device)
    {
        return self::getDeviceNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'registry' => $registry,
            'device' => $device,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - location: projects/{project}/locations/{location}
     * - registry: projects/{project}/locations/{location}/registries/{registry}
     * - device: projects/{project}/locations/{location}/registries/{registry}/devices/{device}.
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
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'cloudiot.googleapis.com:443'.
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
     * Creates a device registry that contains devices.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedParent = $deviceManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     $deviceRegistry = new DeviceRegistry();
     *     $response = $deviceManagerClient->createDeviceRegistry($formattedParent, $deviceRegistry);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string         $parent         The project and cloud region where this device registry must be created.
     *                                       For example, `projects/example-project/locations/us-central1`.
     * @param DeviceRegistry $deviceRegistry The device registry. The field `name` must be empty. The server will
     *                                       generate that field from the device registry `id` provided and the
     *                                       `parent` field.
     * @param array          $optionalArgs   {
     *                                       Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\DeviceRegistry
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createDeviceRegistry($parent, $deviceRegistry, array $optionalArgs = [])
    {
        $request = new CreateDeviceRegistryRequest();
        $request->setParent($parent);
        $request->setDeviceRegistry($deviceRegistry);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateDeviceRegistry',
            DeviceRegistry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets a device registry configuration.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $response = $deviceManagerClient->getDeviceRegistry($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device registry. For example,
     *                             `projects/example-project/locations/us-central1/registries/my-registry`.
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
     * @return \Google\Cloud\Iot\V1\DeviceRegistry
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDeviceRegistry($name, array $optionalArgs = [])
    {
        $request = new GetDeviceRegistryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetDeviceRegistry',
            DeviceRegistry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a device registry configuration.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $deviceRegistry = new DeviceRegistry();
     *     $updateMask = new FieldMask();
     *     $response = $deviceManagerClient->updateDeviceRegistry($deviceRegistry, $updateMask);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param DeviceRegistry $deviceRegistry The new values for the device registry. The `id` field must be empty, and
     *                                       the `name` field must indicate the path of the resource. For example,
     *                                       `projects/example-project/locations/us-central1/registries/my-registry`.
     * @param FieldMask      $updateMask     Only updates the `device_registry` fields indicated by this mask.
     *                                       The field mask must not be empty, and it must not contain fields that
     *                                       are immutable or only set by the server.
     *                                       Mutable top-level fields: `event_notification_config`, `http_config`,
     *                                       `mqtt_config`, and `state_notification_config`.
     * @param array          $optionalArgs   {
     *                                       Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\DeviceRegistry
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateDeviceRegistry($deviceRegistry, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateDeviceRegistryRequest();
        $request->setDeviceRegistry($deviceRegistry);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'device_registry.name' => $request->getDeviceRegistry()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateDeviceRegistry',
            DeviceRegistry::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a device registry configuration.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $deviceManagerClient->deleteDeviceRegistry($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device registry. For example,
     *                             `projects/example-project/locations/us-central1/registries/my-registry`.
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
    public function deleteDeviceRegistry($name, array $optionalArgs = [])
    {
        $request = new DeleteDeviceRegistryRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteDeviceRegistry',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists device registries.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedParent = $deviceManagerClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate through all elements
     *     $pagedResponse = $deviceManagerClient->listDeviceRegistries($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $deviceManagerClient->listDeviceRegistries($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The project and cloud region path. For example,
     *                             `projects/example-project/locations/us-central1`.
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
    public function listDeviceRegistries($parent, array $optionalArgs = [])
    {
        $request = new ListDeviceRegistriesRequest();
        $request->setParent($parent);
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
            'ListDeviceRegistries',
            $optionalArgs,
            ListDeviceRegistriesResponse::class,
            $request
        );
    }

    /**
     * Creates a device in a device registry.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedParent = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $device = new Device();
     *     $response = $deviceManagerClient->createDevice($formattedParent, $device);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The name of the device registry where this device should be created.
     *                             For example,
     *                             `projects/example-project/locations/us-central1/registries/my-registry`.
     * @param Device $device       The device registration details. The field `name` must be empty. The server
     *                             will generate that field from the device registry `id` provided and the
     *                             `parent` field.
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
     * @return \Google\Cloud\Iot\V1\Device
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createDevice($parent, $device, array $optionalArgs = [])
    {
        $request = new CreateDeviceRequest();
        $request->setParent($parent);
        $request->setDevice($device);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateDevice',
            Device::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets details about a device.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->deviceName('[PROJECT]', '[LOCATION]', '[REGISTRY]', '[DEVICE]');
     *     $response = $deviceManagerClient->getDevice($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device. For example,
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/device0` or
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type FieldMask $fieldMask
     *          The fields of the `Device` resource to be returned in the response. If the
     *          field mask is unset or empty, all fields are returned.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\Device
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getDevice($name, array $optionalArgs = [])
    {
        $request = new GetDeviceRequest();
        $request->setName($name);
        if (isset($optionalArgs['fieldMask'])) {
            $request->setFieldMask($optionalArgs['fieldMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetDevice',
            Device::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a device.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $device = new Device();
     *     $updateMask = new FieldMask();
     *     $response = $deviceManagerClient->updateDevice($device, $updateMask);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param Device    $device       The new values for the device registry. The `id` and `num_id` fields must
     *                                be empty, and the field `name` must specify the name path. For example,
     *                                `projects/p0/locations/us-central1/registries/registry0/devices/device0`or
     *                                `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
     * @param FieldMask $updateMask   Only updates the `device` fields indicated by this mask.
     *                                The field mask must not be empty, and it must not contain fields that
     *                                are immutable or only set by the server.
     *                                Mutable top-level fields: `credentials`, `blocked`, and `metadata`
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
     * @return \Google\Cloud\Iot\V1\Device
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateDevice($device, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateDeviceRequest();
        $request->setDevice($device);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'device.name' => $request->getDevice()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateDevice',
            Device::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a device.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->deviceName('[PROJECT]', '[LOCATION]', '[REGISTRY]', '[DEVICE]');
     *     $deviceManagerClient->deleteDevice($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device. For example,
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/device0` or
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
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
    public function deleteDevice($name, array $optionalArgs = [])
    {
        $request = new DeleteDeviceRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteDevice',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * List devices in a device registry.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedParent = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     // Iterate through all elements
     *     $pagedResponse = $deviceManagerClient->listDevices($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $deviceManagerClient->listDevices($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $parent       The device registry path. Required. For example,
     *                             `projects/my-project/locations/us-central1/registries/my-registry`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int[] $deviceNumIds
     *          A list of device numerical ids. If empty, it will ignore this field. This
     *          field cannot hold more than 10,000 entries.
     *     @type string[] $deviceIds
     *          A list of device string identifiers. If empty, it will ignore this field.
     *          For example, `['device0', 'device12']`. This field cannot hold more than
     *          10,000 entries.
     *     @type FieldMask $fieldMask
     *          The fields of the `Device` resource to be returned in the response. The
     *          fields `id`, and `num_id` are always returned by default, along with any
     *          other fields specified.
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
    public function listDevices($parent, array $optionalArgs = [])
    {
        $request = new ListDevicesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['deviceNumIds'])) {
            $request->setDeviceNumIds($optionalArgs['deviceNumIds']);
        }
        if (isset($optionalArgs['deviceIds'])) {
            $request->setDeviceIds($optionalArgs['deviceIds']);
        }
        if (isset($optionalArgs['fieldMask'])) {
            $request->setFieldMask($optionalArgs['fieldMask']);
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
            'ListDevices',
            $optionalArgs,
            ListDevicesResponse::class,
            $request
        );
    }

    /**
     * Modifies the configuration for the device, which is eventually sent from
     * the Cloud IoT Core servers. Returns the modified configuration version and
     * its metadata.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->deviceName('[PROJECT]', '[LOCATION]', '[REGISTRY]', '[DEVICE]');
     *     $binaryData = '';
     *     $response = $deviceManagerClient->modifyCloudToDeviceConfig($formattedName, $binaryData);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device. For example,
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/device0` or
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
     * @param string $binaryData   The configuration data for the device.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $versionToUpdate
     *          The version number to update. If this value is zero, it will not check the
     *          version number of the server and will always update the current version;
     *          otherwise, this update will fail if the version number found on the server
     *          does not match this version number. This is used to support multiple
     *          simultaneous updates without losing data.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\DeviceConfig
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function modifyCloudToDeviceConfig($name, $binaryData, array $optionalArgs = [])
    {
        $request = new ModifyCloudToDeviceConfigRequest();
        $request->setName($name);
        $request->setBinaryData($binaryData);
        if (isset($optionalArgs['versionToUpdate'])) {
            $request->setVersionToUpdate($optionalArgs['versionToUpdate']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ModifyCloudToDeviceConfig',
            DeviceConfig::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the last few versions of the device configuration in descending
     * order (i.e.: newest first).
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->deviceName('[PROJECT]', '[LOCATION]', '[REGISTRY]', '[DEVICE]');
     *     $response = $deviceManagerClient->listDeviceConfigVersions($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device. For example,
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/device0` or
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $numVersions
     *          The number of versions to list. Versions are listed in decreasing order of
     *          the version number. The maximum number of versions retained is 10. If this
     *          value is zero, it will return all the versions available.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\ListDeviceConfigVersionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listDeviceConfigVersions($name, array $optionalArgs = [])
    {
        $request = new ListDeviceConfigVersionsRequest();
        $request->setName($name);
        if (isset($optionalArgs['numVersions'])) {
            $request->setNumVersions($optionalArgs['numVersions']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListDeviceConfigVersions',
            ListDeviceConfigVersionsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the last few versions of the device state in descending order (i.e.:
     * newest first).
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedName = $deviceManagerClient->deviceName('[PROJECT]', '[LOCATION]', '[REGISTRY]', '[DEVICE]');
     *     $response = $deviceManagerClient->listDeviceStates($formattedName);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $name         The name of the device. For example,
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/device0` or
     *                             `projects/p0/locations/us-central1/registries/registry0/devices/{num_id}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $numStates
     *          The number of states to list. States are listed in descending order of
     *          update time. The maximum number of states retained is 10. If this
     *          value is zero, it will return all the states available.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iot\V1\ListDeviceStatesResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listDeviceStates($name, array $optionalArgs = [])
    {
        $request = new ListDeviceStatesRequest();
        $request->setName($name);
        if (isset($optionalArgs['numStates'])) {
            $request->setNumStates($optionalArgs['numStates']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListDeviceStates',
            ListDeviceStatesResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedResource = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $policy = new Policy();
     *     $response = $deviceManagerClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedResource = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $response = $deviceManagerClient->getIamPolicy($formattedResource);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
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
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     *
     * Sample code:
     * ```
     * $deviceManagerClient = new DeviceManagerClient();
     * try {
     *     $formattedResource = $deviceManagerClient->registryName('[PROJECT]', '[LOCATION]', '[REGISTRY]');
     *     $permissions = [];
     *     $response = $deviceManagerClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $deviceManagerClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               `resource` is usually specified as a path. For example, a Project
     *                               resource is specified as `projects/{project}`.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
