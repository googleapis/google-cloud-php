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
 * https://github.com/google/googleapis/blob/master/google/cloud/oslogin/v1beta/oslogin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\OsLogin\V1beta\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\OsLogin\Common\SshPublicKey;
use Google\Cloud\OsLogin\V1beta\DeletePosixAccountRequest;
use Google\Cloud\OsLogin\V1beta\DeleteSshPublicKeyRequest;
use Google\Cloud\OsLogin\V1beta\GetLoginProfileRequest;
use Google\Cloud\OsLogin\V1beta\GetSshPublicKeyRequest;
use Google\Cloud\OsLogin\V1beta\ImportSshPublicKeyRequest;
use Google\Cloud\OsLogin\V1beta\OsLoginServiceGrpcClient;
use Google\Cloud\OsLogin\V1beta\UpdateSshPublicKeyRequest;
use Google\Cloud\Version;
use Google\Protobuf\FieldMask;

/**
 * Service Description: Cloud OS Login API.
 *
 * The Cloud OS Login API allows you to manage users and their associated SSH
 * public keys for logging into virtual machines on Google Cloud Platform.
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
 *     $osLoginServiceClient = new OsLoginServiceClient();
 *     $formattedName = $osLoginServiceClient->projectName('[USER]', '[PROJECT]');
 *     $osLoginServiceClient->deletePosixAccount($formattedName);
 * } finally {
 *     $osLoginServiceClient->close();
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
class OsLoginServiceGapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'oslogin.googleapis.com';

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

    private static $userNameTemplate;
    private static $projectNameTemplate;
    private static $fingerprintNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $osLoginServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    private static function getUserNameTemplate()
    {
        if (self::$userNameTemplate == null) {
            self::$userNameTemplate = new PathTemplate('users/{user}');
        }

        return self::$userNameTemplate;
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('users/{user}/projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getFingerprintNameTemplate()
    {
        if (self::$fingerprintNameTemplate == null) {
            self::$fingerprintNameTemplate = new PathTemplate('users/{user}/sshPublicKeys/{fingerprint}');
        }

        return self::$fingerprintNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'user' => self::getUserNameTemplate(),
                'project' => self::getProjectNameTemplate(),
                'fingerprint' => self::getFingerprintNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a user resource.
     *
     * @param string $user
     *
     * @return string The formatted user resource.
     * @experimental
     */
    public static function userName($user)
    {
        return self::getUserNameTemplate()->render([
            'user' => $user,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $user
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function projectName($user, $project)
    {
        return self::getProjectNameTemplate()->render([
            'user' => $user,
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a fingerprint resource.
     *
     * @param string $user
     * @param string $fingerprint
     *
     * @return string The formatted fingerprint resource.
     * @experimental
     */
    public static function fingerprintName($user, $fingerprint)
    {
        return self::getFingerprintNameTemplate()->render([
            'user' => $user,
            'fingerprint' => $fingerprint,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - user: users/{user}
     * - project: users/{user}/projects/{project}
     * - fingerprint: users/{user}/sshPublicKeys/{fingerprint}.
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'oslogin.googleapis.com'.
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
     *                          Defaults to the scopes for the Google Cloud OS Login API.
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
                'https://www.googleapis.com/auth/cloud-platform.read-only',
                'https://www.googleapis.com/auth/compute',
                'https://www.googleapis.com/auth/compute.readonly',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/os_login_service_client_config.json',
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
            'deletePosixAccount' => $defaultDescriptors,
            'deleteSshPublicKey' => $defaultDescriptors,
            'getLoginProfile' => $defaultDescriptors,
            'getSshPublicKey' => $defaultDescriptors,
            'importSshPublicKey' => $defaultDescriptors,
            'updateSshPublicKey' => $defaultDescriptors,
        ];

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.cloud.oslogin.v1beta.OsLoginService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createOsLoginServiceStubFunction = function ($hostname, $opts, $channel) {
            return new OsLoginServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createOsLoginServiceStubFunction', $options)) {
            $createOsLoginServiceStubFunction = $options['createOsLoginServiceStubFunction'];
        }
        $this->osLoginServiceStub = $this->grpcCredentialsHelper->createStub($createOsLoginServiceStubFunction);
    }

    /**
     * Deletes a POSIX account.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedName = $osLoginServiceClient->projectName('[USER]', '[PROJECT]');
     *     $osLoginServiceClient->deletePosixAccount($formattedName);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string $name         A reference to the POSIX account to update. POSIX accounts are identified
     *                             by the project ID they are associated with. A reference to the POSIX
     *                             account is in format `users/{user}/projects/{project}`.
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
    public function deletePosixAccount($name, $optionalArgs = [])
    {
        $request = new DeletePosixAccountRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deletePosixAccount'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'DeletePosixAccount',
            $mergedSettings,
            $this->descriptors['deletePosixAccount']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes an SSH public key.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedName = $osLoginServiceClient->fingerprintName('[USER]', '[FINGERPRINT]');
     *     $osLoginServiceClient->deleteSshPublicKey($formattedName);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The fingerprint of the public key to update. Public keys are identified by
     *                             their SHA-256 fingerprint. The fingerprint of the public key is in format
     *                             `users/{user}/sshPublicKeys/{fingerprint}`.
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
    public function deleteSshPublicKey($name, $optionalArgs = [])
    {
        $request = new DeleteSshPublicKeyRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteSshPublicKey'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'DeleteSshPublicKey',
            $mergedSettings,
            $this->descriptors['deleteSshPublicKey']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Retrieves the profile information used for logging in to a virtual machine
     * on Google Compute Engine.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedName = $osLoginServiceClient->userName('[USER]');
     *     $response = $osLoginServiceClient->getLoginProfile($formattedName);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The unique ID for the user in format `users/{user}`.
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
     * @return \Google\Cloud\OsLogin\V1beta\LoginProfile
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getLoginProfile($name, $optionalArgs = [])
    {
        $request = new GetLoginProfileRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getLoginProfile'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'GetLoginProfile',
            $mergedSettings,
            $this->descriptors['getLoginProfile']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Retrieves an SSH public key.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedName = $osLoginServiceClient->fingerprintName('[USER]', '[FINGERPRINT]');
     *     $response = $osLoginServiceClient->getSshPublicKey($formattedName);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The fingerprint of the public key to retrieve. Public keys are identified
     *                             by their SHA-256 fingerprint. The fingerprint of the public key is in
     *                             format `users/{user}/sshPublicKeys/{fingerprint}`.
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
     * @return \Google\Cloud\OsLogin\Common\SshPublicKey
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getSshPublicKey($name, $optionalArgs = [])
    {
        $request = new GetSshPublicKeyRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getSshPublicKey'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'GetSshPublicKey',
            $mergedSettings,
            $this->descriptors['getSshPublicKey']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Adds an SSH public key and returns the profile information. Default POSIX
     * account information is set when no username and UID exist as part of the
     * login profile.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedParent = $osLoginServiceClient->userName('[USER]');
     *     $sshPublicKey = new SshPublicKey();
     *     $response = $osLoginServiceClient->importSshPublicKey($formattedParent, $sshPublicKey);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string       $parent       The unique ID for the user in format `users/{user}`.
     * @param SshPublicKey $sshPublicKey The SSH public key and expiration time.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type string $projectId
     *          The project ID of the Google Cloud Platform project.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\OsLogin\V1beta\ImportSshPublicKeyResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function importSshPublicKey($parent, $sshPublicKey, $optionalArgs = [])
    {
        $request = new ImportSshPublicKeyRequest();
        $request->setParent($parent);
        $request->setSshPublicKey($sshPublicKey);
        if (isset($optionalArgs['projectId'])) {
            $request->setProjectId($optionalArgs['projectId']);
        }

        $defaultCallSettings = $this->defaultCallSettings['importSshPublicKey'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'ImportSshPublicKey',
            $mergedSettings,
            $this->descriptors['importSshPublicKey']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates an SSH public key and returns the profile information. This method
     * supports patch semantics.
     *
     * Sample code:
     * ```
     * try {
     *     $osLoginServiceClient = new OsLoginServiceClient();
     *     $formattedName = $osLoginServiceClient->fingerprintName('[USER]', '[FINGERPRINT]');
     *     $sshPublicKey = new SshPublicKey();
     *     $response = $osLoginServiceClient->updateSshPublicKey($formattedName, $sshPublicKey);
     * } finally {
     *     $osLoginServiceClient->close();
     * }
     * ```
     *
     * @param string       $name         The fingerprint of the public key to update. Public keys are identified by
     *                                   their SHA-256 fingerprint. The fingerprint of the public key is in format
     *                                   `users/{user}/sshPublicKeys/{fingerprint}`.
     * @param SshPublicKey $sshPublicKey The SSH public key and expiration time.
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type FieldMask $updateMask
     *          Mask to control which fields get updated. Updates all if not present.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\OsLogin\Common\SshPublicKey
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateSshPublicKey($name, $sshPublicKey, $optionalArgs = [])
    {
        $request = new UpdateSshPublicKeyRequest();
        $request->setName($name);
        $request->setSshPublicKey($sshPublicKey);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $defaultCallSettings = $this->defaultCallSettings['updateSshPublicKey'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->osLoginServiceStub,
            'UpdateSshPublicKey',
            $mergedSettings,
            $this->descriptors['updateSshPublicKey']
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
        $this->osLoginServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}
