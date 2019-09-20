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
 * https://github.com/google/googleapis/blob/master/google/cloud/recaptchaenterprise/v1beta1/recaptchaenterprise.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\RecaptchaEnterprise\V1beta1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest;
use Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest_Annotation;
use Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentResponse;
use Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1beta1\CreateAssessmentRequest;

/**
 * Service Description: Service to determine the likelihood an event is legitimate.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $recaptchaEnterpriseServiceV1Beta1Client = new RecaptchaEnterpriseServiceV1Beta1Client();
 * try {
 *     $formattedParent = $recaptchaEnterpriseServiceV1Beta1Client->projectName('[PROJECT]');
 *     $assessment = new Assessment();
 *     $response = $recaptchaEnterpriseServiceV1Beta1Client->createAssessment($formattedParent, $assessment);
 * } finally {
 *     $recaptchaEnterpriseServiceV1Beta1Client->close();
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
class RecaptchaEnterpriseServiceV1Beta1GapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'recaptchaenterprise.googleapis.com';

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
    private static $assessmentNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/recaptcha_enterprise_service_v1_beta1_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/recaptcha_enterprise_service_v1_beta1_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/recaptcha_enterprise_service_v1_beta1_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/recaptcha_enterprise_service_v1_beta1_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAssessmentNameTemplate()
    {
        if (null == self::$assessmentNameTemplate) {
            self::$assessmentNameTemplate = new PathTemplate('projects/{project}/assessments/{assessment}');
        }

        return self::$assessmentNameTemplate;
    }

    private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'assessment' => self::getAssessmentNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a assessment resource.
     *
     * @param string $project
     * @param string $assessment
     *
     * @return string The formatted assessment resource.
     * @experimental
     */
    public static function assessmentName($project, $assessment)
    {
        return self::getAssessmentNameTemplate()->render([
            'project' => $project,
            'assessment' => $assessment,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - assessment: projects/{project}/assessments/{assessment}
     * - project: projects/{project}.
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
     *           as "<uri>:<port>". Default 'recaptchaenterprise.googleapis.com:443'.
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
     * Creates an Assessment of the likelihood an event is legitimate.
     *
     * Sample code:
     * ```
     * $recaptchaEnterpriseServiceV1Beta1Client = new RecaptchaEnterpriseServiceV1Beta1Client();
     * try {
     *     $formattedParent = $recaptchaEnterpriseServiceV1Beta1Client->projectName('[PROJECT]');
     *     $assessment = new Assessment();
     *     $response = $recaptchaEnterpriseServiceV1Beta1Client->createAssessment($formattedParent, $assessment);
     * } finally {
     *     $recaptchaEnterpriseServiceV1Beta1Client->close();
     * }
     * ```
     *
     * @param string     $parent       Required. The name of the project in which the assessment will be created,
     *                                 in the format "projects/{project_number}".
     * @param Assessment $assessment   The asessment details.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\RecaptchaEnterprise\V1beta1\Assessment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createAssessment($parent, $assessment, array $optionalArgs = [])
    {
        $request = new CreateAssessmentRequest();
        $request->setParent($parent);
        $request->setAssessment($assessment);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateAssessment',
            Assessment::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Annotates a previously created Assessment to provide additional information
     * on whether the event turned out to be authentic or fradulent.
     *
     * Sample code:
     * ```
     * $recaptchaEnterpriseServiceV1Beta1Client = new RecaptchaEnterpriseServiceV1Beta1Client();
     * try {
     *     $formattedName = $recaptchaEnterpriseServiceV1Beta1Client->assessmentName('[PROJECT]', '[ASSESSMENT]');
     *     $annotation = AnnotateAssessmentRequest_Annotation::ANNOTATION_UNSPECIFIED;
     *     $response = $recaptchaEnterpriseServiceV1Beta1Client->annotateAssessment($formattedName, $annotation);
     * } finally {
     *     $recaptchaEnterpriseServiceV1Beta1Client->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the Assessment, in the format
     *                             "projects/{project_number}/assessments/{assessment_id}".
     * @param int    $annotation   The annotation that will be assigned to the Event.
     *                             For allowed values, use constants defined on {@see \Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentRequest_Annotation}
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
     * @return \Google\Cloud\RecaptchaEnterprise\V1beta1\AnnotateAssessmentResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function annotateAssessment($name, $annotation, array $optionalArgs = [])
    {
        $request = new AnnotateAssessmentRequest();
        $request->setName($name);
        $request->setAnnotation($annotation);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'AnnotateAssessment',
            AnnotateAssessmentResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
