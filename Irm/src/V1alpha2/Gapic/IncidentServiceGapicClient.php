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
 * https://github.com/google/googleapis/blob/master/google/cloud/irm/v1alpha2/incidents_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Irm\V1alpha2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Irm\V1alpha2\AcknowledgeSignalRequest;
use Google\Cloud\Irm\V1alpha2\AcknowledgeSignalResponse;
use Google\Cloud\Irm\V1alpha2\Annotation;
use Google\Cloud\Irm\V1alpha2\Artifact;
use Google\Cloud\Irm\V1alpha2\CancelIncidentRoleHandoverRequest;
use Google\Cloud\Irm\V1alpha2\ConfirmIncidentRoleHandoverRequest;
use Google\Cloud\Irm\V1alpha2\CreateAnnotationRequest;
use Google\Cloud\Irm\V1alpha2\CreateArtifactRequest;
use Google\Cloud\Irm\V1alpha2\CreateIncidentRequest;
use Google\Cloud\Irm\V1alpha2\CreateIncidentRoleAssignmentRequest;
use Google\Cloud\Irm\V1alpha2\CreateSignalRequest;
use Google\Cloud\Irm\V1alpha2\CreateSubscriptionRequest;
use Google\Cloud\Irm\V1alpha2\CreateTagRequest;
use Google\Cloud\Irm\V1alpha2\DeleteArtifactRequest;
use Google\Cloud\Irm\V1alpha2\DeleteIncidentRoleAssignmentRequest;
use Google\Cloud\Irm\V1alpha2\DeleteSubscriptionRequest;
use Google\Cloud\Irm\V1alpha2\DeleteTagRequest;
use Google\Cloud\Irm\V1alpha2\EscalateIncidentRequest;
use Google\Cloud\Irm\V1alpha2\EscalateIncidentResponse;
use Google\Cloud\Irm\V1alpha2\ForceIncidentRoleHandoverRequest;
use Google\Cloud\Irm\V1alpha2\GetIncidentRequest;
use Google\Cloud\Irm\V1alpha2\GetShiftHandoffPresetsRequest;
use Google\Cloud\Irm\V1alpha2\GetSignalRequest;
use Google\Cloud\Irm\V1alpha2\Incident;
use Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment;
use Google\Cloud\Irm\V1alpha2\ListAnnotationsRequest;
use Google\Cloud\Irm\V1alpha2\ListAnnotationsResponse;
use Google\Cloud\Irm\V1alpha2\ListArtifactsRequest;
use Google\Cloud\Irm\V1alpha2\ListArtifactsResponse;
use Google\Cloud\Irm\V1alpha2\ListIncidentRoleAssignmentsRequest;
use Google\Cloud\Irm\V1alpha2\ListIncidentRoleAssignmentsResponse;
use Google\Cloud\Irm\V1alpha2\ListSignalsRequest;
use Google\Cloud\Irm\V1alpha2\ListSignalsResponse;
use Google\Cloud\Irm\V1alpha2\ListSubscriptionsRequest;
use Google\Cloud\Irm\V1alpha2\ListSubscriptionsResponse;
use Google\Cloud\Irm\V1alpha2\ListTagsRequest;
use Google\Cloud\Irm\V1alpha2\ListTagsResponse;
use Google\Cloud\Irm\V1alpha2\RequestIncidentRoleHandoverRequest;
use Google\Cloud\Irm\V1alpha2\SearchIncidentsRequest;
use Google\Cloud\Irm\V1alpha2\SearchIncidentsResponse;
use Google\Cloud\Irm\V1alpha2\SearchSimilarIncidentsRequest;
use Google\Cloud\Irm\V1alpha2\SearchSimilarIncidentsResponse;
use Google\Cloud\Irm\V1alpha2\SendShiftHandoffRequest;
use Google\Cloud\Irm\V1alpha2\SendShiftHandoffRequest_Incident;
use Google\Cloud\Irm\V1alpha2\SendShiftHandoffResponse;
use Google\Cloud\Irm\V1alpha2\ShiftHandoffPresets;
use Google\Cloud\Irm\V1alpha2\Signal;
use Google\Cloud\Irm\V1alpha2\Subscription;
use Google\Cloud\Irm\V1alpha2\Tag;
use Google\Cloud\Irm\V1alpha2\UpdateAnnotationRequest;
use Google\Cloud\Irm\V1alpha2\UpdateArtifactRequest;
use Google\Cloud\Irm\V1alpha2\UpdateIncidentRequest;
use Google\Cloud\Irm\V1alpha2\UpdateSignalRequest;
use Google\Cloud\Irm\V1alpha2\User;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The Incident API for Incident Response & Management.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $incidentServiceClient = new IncidentServiceClient();
 * try {
 *     $incident = new Incident();
 *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
 *     $response = $incidentServiceClient->createIncident($incident, $formattedParent);
 * } finally {
 *     $incidentServiceClient->close();
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
class IncidentServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.irm.v1alpha2.IncidentService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'irm.googleapis.com';

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
    ];
    private static $projectNameTemplate;
    private static $incidentNameTemplate;
    private static $annotationNameTemplate;
    private static $artifactNameTemplate;
    private static $roleAssignmentNameTemplate;
    private static $subscriptionNameTemplate;
    private static $tagNameTemplate;
    private static $signalNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/incident_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/incident_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/incident_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/incident_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getIncidentNameTemplate()
    {
        if (null == self::$incidentNameTemplate) {
            self::$incidentNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}');
        }

        return self::$incidentNameTemplate;
    }

    private static function getAnnotationNameTemplate()
    {
        if (null == self::$annotationNameTemplate) {
            self::$annotationNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}/annotations/{annotation}');
        }

        return self::$annotationNameTemplate;
    }

    private static function getArtifactNameTemplate()
    {
        if (null == self::$artifactNameTemplate) {
            self::$artifactNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}/artifacts/{artifact}');
        }

        return self::$artifactNameTemplate;
    }

    private static function getRoleAssignmentNameTemplate()
    {
        if (null == self::$roleAssignmentNameTemplate) {
            self::$roleAssignmentNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}/roleAssignments/{role_assignment}');
        }

        return self::$roleAssignmentNameTemplate;
    }

    private static function getSubscriptionNameTemplate()
    {
        if (null == self::$subscriptionNameTemplate) {
            self::$subscriptionNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}/subscriptions/{subscription}');
        }

        return self::$subscriptionNameTemplate;
    }

    private static function getTagNameTemplate()
    {
        if (null == self::$tagNameTemplate) {
            self::$tagNameTemplate = new PathTemplate('projects/{project}/incidents/{incident}/tags/{tag}');
        }

        return self::$tagNameTemplate;
    }

    private static function getSignalNameTemplate()
    {
        if (null == self::$signalNameTemplate) {
            self::$signalNameTemplate = new PathTemplate('projects/{project}/signals/{signal}');
        }

        return self::$signalNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'incident' => self::getIncidentNameTemplate(),
                'annotation' => self::getAnnotationNameTemplate(),
                'artifact' => self::getArtifactNameTemplate(),
                'roleAssignment' => self::getRoleAssignmentNameTemplate(),
                'subscription' => self::getSubscriptionNameTemplate(),
                'tag' => self::getTagNameTemplate(),
                'signal' => self::getSignalNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * Formats a string containing the fully-qualified path to represent
     * a incident resource.
     *
     * @param string $project
     * @param string $incident
     *
     * @return string The formatted incident resource.
     * @experimental
     */
    public static function incidentName($project, $incident)
    {
        return self::getIncidentNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a annotation resource.
     *
     * @param string $project
     * @param string $incident
     * @param string $annotation
     *
     * @return string The formatted annotation resource.
     * @experimental
     */
    public static function annotationName($project, $incident, $annotation)
    {
        return self::getAnnotationNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
            'annotation' => $annotation,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a artifact resource.
     *
     * @param string $project
     * @param string $incident
     * @param string $artifact
     *
     * @return string The formatted artifact resource.
     * @experimental
     */
    public static function artifactName($project, $incident, $artifact)
    {
        return self::getArtifactNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
            'artifact' => $artifact,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a role_assignment resource.
     *
     * @param string $project
     * @param string $incident
     * @param string $roleAssignment
     *
     * @return string The formatted role_assignment resource.
     * @experimental
     */
    public static function roleAssignmentName($project, $incident, $roleAssignment)
    {
        return self::getRoleAssignmentNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
            'role_assignment' => $roleAssignment,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a subscription resource.
     *
     * @param string $project
     * @param string $incident
     * @param string $subscription
     *
     * @return string The formatted subscription resource.
     * @experimental
     */
    public static function subscriptionName($project, $incident, $subscription)
    {
        return self::getSubscriptionNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
            'subscription' => $subscription,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a tag resource.
     *
     * @param string $project
     * @param string $incident
     * @param string $tag
     *
     * @return string The formatted tag resource.
     * @experimental
     */
    public static function tagName($project, $incident, $tag)
    {
        return self::getTagNameTemplate()->render([
            'project' => $project,
            'incident' => $incident,
            'tag' => $tag,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a signal resource.
     *
     * @param string $project
     * @param string $signal
     *
     * @return string The formatted signal resource.
     * @experimental
     */
    public static function signalName($project, $signal)
    {
        return self::getSignalNameTemplate()->render([
            'project' => $project,
            'signal' => $signal,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - incident: projects/{project}/incidents/{incident}
     * - annotation: projects/{project}/incidents/{incident}/annotations/{annotation}
     * - artifact: projects/{project}/incidents/{incident}/artifacts/{artifact}
     * - roleAssignment: projects/{project}/incidents/{incident}/roleAssignments/{role_assignment}
     * - subscription: projects/{project}/incidents/{incident}/subscriptions/{subscription}
     * - tag: projects/{project}/incidents/{incident}/tags/{tag}
     * - signal: projects/{project}/signals/{signal}.
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
     *           as "<uri>:<port>". Default 'irm.googleapis.com:443'.
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
     * Creates a new incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $incident = new Incident();
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     $response = $incidentServiceClient->createIncident($incident, $formattedParent);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Incident $incident     The incident to create.
     * @param string   $parent       The resource name of the hosting Stackdriver project which the incident
     *                               belongs to.
     *                               The name is of the form `projects/{project_id_or_number}`
     *                               .
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
     * @return \Google\Cloud\Irm\V1alpha2\Incident
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createIncident($incident, $parent, array $optionalArgs = [])
    {
        $request = new CreateIncidentRequest();
        $request->setIncident($incident);
        $request->setParent($parent);

        return $this->startCall(
            'CreateIncident',
            Incident::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns an incident by name.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $response = $incidentServiceClient->getIncident($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
     * @return \Google\Cloud\Irm\V1alpha2\Incident
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIncident($name, array $optionalArgs = [])
    {
        $request = new GetIncidentRequest();
        $request->setName($name);

        return $this->startCall(
            'GetIncident',
            Incident::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns a list of incidents.
     * Incidents are ordered by start time, with the most recent incidents first.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->searchIncidents($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->searchIncidents($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       The resource name of the hosting Stackdriver project which requested
     *                             incidents belong to.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $query
     *          An expression that defines which incidents to return.
     *
     *          Search atoms can be used to match certain specific fields.  Otherwise,
     *          plain text will match text fields in the incident.
     *
     *          Search atoms:
     *          * `start` - (timestamp) The time the incident started.
     *          * `stage` - The stage of the incident, one of detected, triaged, mitigated,
     *            resolved, documented, or duplicate (which correspond to values in the
     *            Incident.Stage enum). These are ordered, so `stage<resolved` is
     *            equivalent to `stage:detected OR stage:triaged OR stage:mitigated`.
     *          * `severity` - (Incident.Severity) The severity of the incident.
     *             + Supports matching on a specific severity (e.g., `severity:major`) or
     *               on a range (e.g., `severity>medium`, `severity<=minor`, etc.).
     *
     *          Timestamp formats:
     *          * yyyy-MM-dd - an absolute date, treated as a calendar-day-wide window.
     *            In other words, the "<" operator will match dates before that date, the
     *            ">" operator will match dates after that date, and the ":" or "="
     *            operators will match the entire day.
     *          * Nd (e.g. 7d) - a relative number of days ago, treated as a moment in time
     *            (as opposed to a day-wide span) a multiple of 24 hours ago (as opposed to
     *            calendar days).  In the case of daylight savings time, it will apply the
     *            current timezone to both ends of the range.  Note that exact matching
     *            (e.g. `start:7d`) is unlikely to be useful because that would only match
     *            incidents created precisely at a particular instant in time.
     *
     *          Examples:
     *
     *          * `foo` - matches incidents containing the word "foo"
     *          * `"foo bar"` - matches incidents containing the phrase "foo bar"
     *          * `foo bar` or `foo AND bar` - matches incidents containing the words "foo"
     *            and "bar"
     *          * `foo -bar` or `foo AND NOT bar` - matches incidents containing the word
     *            "foo" but not the word "bar"
     *          * `foo OR bar` - matches incidents containing the word "foo" or the word
     *            "bar"
     *          * `start>2018-11-28` - matches incidents which started after November 11,
     *            2018.
     *          * `start<=2018-11-28` - matches incidents which started on or before
     *            November 11, 2018.
     *          * `start:2018-11-28` - matches incidents which started on November 11,
     *            2018.
     *          * `start>7d` - matches incidents which started after the point in time 7*24
     *            hours ago
     *          * `start>180d` - similar to 7d, but likely to cross the daylight savings
     *            time boundary, so the end time will be 1 hour different from "now."
     *          * `foo AND start>90d AND stage<resolved` - unresolved incidents from the
     *            past 90 days containing the word "foo"
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type string $timeZone
     *          The time zone name. It should be an IANA TZ name, such as
     *          "America/Los_Angeles". For more information,
     *          see https://en.wikipedia.org/wiki/List_of_tz_database_time_zones.
     *          If no time zone is specified, the default is UTC.
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
    public function searchIncidents($parent, array $optionalArgs = [])
    {
        $request = new SearchIncidentsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['query'])) {
            $request->setQuery($optionalArgs['query']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['timeZone'])) {
            $request->setTimeZone($optionalArgs['timeZone']);
        }

        return $this->getPagedListResponse(
            'SearchIncidents',
            $optionalArgs,
            SearchIncidentsResponse::class,
            $request
        );
    }

    /**
     * Updates an existing incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $incident = new Incident();
     *     $response = $incidentServiceClient->updateIncident($incident);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Incident $incident     The incident to update with the new values.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type FieldMask $updateMask
     *          List of fields that should be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\Incident
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateIncident($incident, array $optionalArgs = [])
    {
        $request = new UpdateIncidentRequest();
        $request->setIncident($incident);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        return $this->startCall(
            'UpdateIncident',
            Incident::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns a list of incidents that are "similar" to the specified incident
     * or signal. This functionality is provided on a best-effort basis and the
     * definition of "similar" is subject to change.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->searchSimilarIncidents($formattedName);
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
     *     $pagedResponse = $incidentServiceClient->searchSimilarIncidents($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the incident or signal, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function searchSimilarIncidents($name, array $optionalArgs = [])
    {
        $request = new SearchSimilarIncidentsRequest();
        $request->setName($name);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'SearchSimilarIncidents',
            $optionalArgs,
            SearchSimilarIncidentsResponse::class,
            $request
        );
    }

    /**
     * Creates an annotation on an existing incident. Only 'text/plain' and
     * 'text/markdown' annotations can be created via this method.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $annotation = new Annotation();
     *     $response = $incidentServiceClient->createAnnotation($formattedParent, $annotation);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string     $parent       Resource name of the incident, e.g.
     *                                 "projects/{project_id}/incidents/{incident_id}".
     * @param Annotation $annotation   Only annotation.content is an input argument.
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
     * @return \Google\Cloud\Irm\V1alpha2\Annotation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createAnnotation($parent, $annotation, array $optionalArgs = [])
    {
        $request = new CreateAnnotationRequest();
        $request->setParent($parent);
        $request->setAnnotation($annotation);

        return $this->startCall(
            'CreateAnnotation',
            Annotation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists annotations that are part of an incident. No assumptions should be
     * made on the content-type of the annotation returned.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listAnnotations($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listAnnotations($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function listAnnotations($parent, array $optionalArgs = [])
    {
        $request = new ListAnnotationsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListAnnotations',
            $optionalArgs,
            ListAnnotationsResponse::class,
            $request
        );
    }

    /**
     * Updates an annotation on an existing incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $annotation = new Annotation();
     *     $response = $incidentServiceClient->updateAnnotation($annotation);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Annotation $annotation   The annotation to update with the new values.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type FieldMask $updateMask
     *          List of fields that should be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\Annotation
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateAnnotation($annotation, array $optionalArgs = [])
    {
        $request = new UpdateAnnotationRequest();
        $request->setAnnotation($annotation);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        return $this->startCall(
            'UpdateAnnotation',
            Annotation::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a tag on an existing incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $tag = new Tag();
     *     $response = $incidentServiceClient->createTag($formattedParent, $tag);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
     * @param Tag    $tag          Tag to create. Only tag.display_name is an input argument.
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
     * @return \Google\Cloud\Irm\V1alpha2\Tag
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createTag($parent, $tag, array $optionalArgs = [])
    {
        $request = new CreateTagRequest();
        $request->setParent($parent);
        $request->setTag($tag);

        return $this->startCall(
            'CreateTag',
            Tag::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an existing tag.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->tagName('[PROJECT]', '[INCIDENT]', '[TAG]');
     *     $incidentServiceClient->deleteTag($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the tag.
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
    public function deleteTag($name, array $optionalArgs = [])
    {
        $request = new DeleteTagRequest();
        $request->setName($name);

        return $this->startCall(
            'DeleteTag',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists tags that are part of an incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listTags($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listTags($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function listTags($parent, array $optionalArgs = [])
    {
        $request = new ListTagsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListTags',
            $optionalArgs,
            ListTagsResponse::class,
            $request
        );
    }

    /**
     * Creates a new signal.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     $signal = new Signal();
     *     $response = $incidentServiceClient->createSignal($formattedParent, $signal);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       The resource name of the hosting Stackdriver project which requested
     *                             signal belongs to.
     * @param Signal $signal       The signal to create.
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
     * @return \Google\Cloud\Irm\V1alpha2\Signal
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSignal($parent, $signal, array $optionalArgs = [])
    {
        $request = new CreateSignalRequest();
        $request->setParent($parent);
        $request->setSignal($signal);

        return $this->startCall(
            'CreateSignal',
            Signal::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists signals that are part of an incident.
     * Signals are returned in reverse chronological order.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listSignals($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listSignals($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       The resource name of the hosting Stackdriver project which requested
     *                             incidents belong to.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          Filter to specify which signals should be returned.
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
    public function listSignals($parent, array $optionalArgs = [])
    {
        $request = new ListSignalsRequest();
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

        return $this->getPagedListResponse(
            'ListSignals',
            $optionalArgs,
            ListSignalsResponse::class,
            $request
        );
    }

    /**
     * Returns a signal by name.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->signalName('[PROJECT]', '[SIGNAL]');
     *     $response = $incidentServiceClient->getSignal($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the Signal resource, e.g.
     *                             "projects/{project_id}/signals/{signal_id}".
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
     * @return \Google\Cloud\Irm\V1alpha2\Signal
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getSignal($name, array $optionalArgs = [])
    {
        $request = new GetSignalRequest();
        $request->setName($name);

        return $this->startCall(
            'GetSignal',
            Signal::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing signal (e.g. to assign/unassign it to an
     * incident).
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $signal = new Signal();
     *     $response = $incidentServiceClient->updateSignal($signal);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Signal $signal       The signal to update with the new values.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type FieldMask $updateMask
     *          List of fields that should be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\Signal
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateSignal($signal, array $optionalArgs = [])
    {
        $request = new UpdateSignalRequest();
        $request->setSignal($signal);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        return $this->startCall(
            'UpdateSignal',
            Signal::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Acks a signal. This acknowledges the signal in the underlying system,
     * indicating that the caller takes responsibility for looking into this.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->signalName('[PROJECT]', '[SIGNAL]');
     *     $response = $incidentServiceClient->acknowledgeSignal($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the Signal resource, e.g.
     *                             "projects/{project_id}/signals/{signal_id}".
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
     * @return \Google\Cloud\Irm\V1alpha2\AcknowledgeSignalResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function acknowledgeSignal($name, array $optionalArgs = [])
    {
        $request = new AcknowledgeSignalRequest();
        $request->setName($name);

        return $this->startCall(
            'AcknowledgeSignal',
            AcknowledgeSignalResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Escalates an incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $incident = new Incident();
     *     $response = $incidentServiceClient->escalateIncident($incident);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Incident $incident     The incident to escalate with the new values.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type FieldMask $updateMask
     *          List of fields that should be updated.
     *     @type Subscription[] $subscriptions
     *          Subscriptions to add or update. Existing subscriptions with the same
     *          channel and address as a subscription in the list will be updated.
     *     @type Tag[] $tags
     *          Tags to add. Tags identical to existing tags will be ignored.
     *     @type IncidentRoleAssignment[] $roles
     *          Roles to add or update. Existing roles with the same type (and title, for
     *          TYPE_OTHER roles) will be updated.
     *     @type Artifact[] $artifacts
     *          Artifacts to add. All artifacts are added without checking for duplicates.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\EscalateIncidentResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function escalateIncident($incident, array $optionalArgs = [])
    {
        $request = new EscalateIncidentRequest();
        $request->setIncident($incident);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }
        if (isset($optionalArgs['subscriptions'])) {
            $request->setSubscriptions($optionalArgs['subscriptions']);
        }
        if (isset($optionalArgs['tags'])) {
            $request->setTags($optionalArgs['tags']);
        }
        if (isset($optionalArgs['roles'])) {
            $request->setRoles($optionalArgs['roles']);
        }
        if (isset($optionalArgs['artifacts'])) {
            $request->setArtifacts($optionalArgs['artifacts']);
        }

        return $this->startCall(
            'EscalateIncident',
            EscalateIncidentResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new artifact.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $artifact = new Artifact();
     *     $response = $incidentServiceClient->createArtifact($formattedParent, $artifact);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       Resource name of the incident, e.g.
     *                               "projects/{project_id}/incidents/{incident_id}".
     * @param Artifact $artifact     The artifact to create.
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
     * @return \Google\Cloud\Irm\V1alpha2\Artifact
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createArtifact($parent, $artifact, array $optionalArgs = [])
    {
        $request = new CreateArtifactRequest();
        $request->setParent($parent);
        $request->setArtifact($artifact);

        return $this->startCall(
            'CreateArtifact',
            Artifact::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns a list of artifacts for an incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listArtifacts($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listArtifacts($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function listArtifacts($parent, array $optionalArgs = [])
    {
        $request = new ListArtifactsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListArtifacts',
            $optionalArgs,
            ListArtifactsResponse::class,
            $request
        );
    }

    /**
     * Updates an existing artifact.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $artifact = new Artifact();
     *     $response = $incidentServiceClient->updateArtifact($artifact);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param Artifact $artifact     The artifact to update with the new values.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type FieldMask $updateMask
     *          List of fields that should be updated.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\Artifact
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateArtifact($artifact, array $optionalArgs = [])
    {
        $request = new UpdateArtifactRequest();
        $request->setArtifact($artifact);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        return $this->startCall(
            'UpdateArtifact',
            Artifact::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an existing artifact.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->artifactName('[PROJECT]', '[INCIDENT]', '[ARTIFACT]');
     *     $incidentServiceClient->deleteArtifact($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the artifact.
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
    public function deleteArtifact($name, array $optionalArgs = [])
    {
        $request = new DeleteArtifactRequest();
        $request->setName($name);

        return $this->startCall(
            'DeleteArtifact',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns "presets" specific to shift handoff (see SendShiftHandoff), e.g.
     * default values for handoff message fields.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     $response = $incidentServiceClient->getShiftHandoffPresets($formattedParent);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the Stackdriver project that the presets belong to. e.g.
     *                             `projects/{project_id}`
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
     * @return \Google\Cloud\Irm\V1alpha2\ShiftHandoffPresets
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getShiftHandoffPresets($parent, array $optionalArgs = [])
    {
        $request = new GetShiftHandoffPresetsRequest();
        $request->setParent($parent);

        return $this->startCall(
            'GetShiftHandoffPresets',
            ShiftHandoffPresets::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sends a summary of the shift for oncall handoff.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->projectName('[PROJECT]');
     *     $recipients = [];
     *     $subject = '';
     *     $response = $incidentServiceClient->sendShiftHandoff($formattedParent, $recipients, $subject);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string   $parent       The resource name of the Stackdriver project that the handoff is being sent
     *                               from. e.g. `projects/{project_id}`
     * @param string[] $recipients   Email addresses of the recipients of the handoff, e.g. "user&#64;example.com".
     *                               Must contain at least one entry.
     * @param string   $subject      The subject of the email. Required.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string[] $cc
     *          Email addresses that should be CC'd on the handoff. Optional.
     *     @type string $notesContentType
     *          Content type string, e.g. 'text/plain' or 'text/html'.
     *     @type string $notesContent
     *          Additional notes to be included in the handoff. Optional.
     *     @type SendShiftHandoffRequest_Incident[] $incidents
     *          The set of incidents that should be included in the handoff. Optional.
     *     @type bool $previewOnly
     *          If set to true a ShiftHandoffResponse will be returned but the handoff
     *          will not actually be sent.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\SendShiftHandoffResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function sendShiftHandoff($parent, $recipients, $subject, array $optionalArgs = [])
    {
        $request = new SendShiftHandoffRequest();
        $request->setParent($parent);
        $request->setRecipients($recipients);
        $request->setSubject($subject);
        if (isset($optionalArgs['cc'])) {
            $request->setCc($optionalArgs['cc']);
        }
        if (isset($optionalArgs['notesContentType'])) {
            $request->setNotesContentType($optionalArgs['notesContentType']);
        }
        if (isset($optionalArgs['notesContent'])) {
            $request->setNotesContent($optionalArgs['notesContent']);
        }
        if (isset($optionalArgs['incidents'])) {
            $request->setIncidents($optionalArgs['incidents']);
        }
        if (isset($optionalArgs['previewOnly'])) {
            $request->setPreviewOnly($optionalArgs['previewOnly']);
        }

        return $this->startCall(
            'SendShiftHandoff',
            SendShiftHandoffResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new subscription.
     * This will fail if:
     *    a. there are too many (50) subscriptions in the incident already
     *    b. a subscription using the given channel already exists.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $subscription = new Subscription();
     *     $response = $incidentServiceClient->createSubscription($formattedParent, $subscription);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string       $parent       Resource name of the incident, e.g.
     *                                   "projects/{project_id}/incidents/{incident_id}".
     * @param Subscription $subscription The subscription to create.
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
     * @return \Google\Cloud\Irm\V1alpha2\Subscription
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createSubscription($parent, $subscription, array $optionalArgs = [])
    {
        $request = new CreateSubscriptionRequest();
        $request->setParent($parent);
        $request->setSubscription($subscription);

        return $this->startCall(
            'CreateSubscription',
            Subscription::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns a list of subscriptions for an incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listSubscriptions($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listSubscriptions($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function listSubscriptions($parent, array $optionalArgs = [])
    {
        $request = new ListSubscriptionsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListSubscriptions',
            $optionalArgs,
            ListSubscriptionsResponse::class,
            $request
        );
    }

    /**
     * Deletes an existing subscription.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->subscriptionName('[PROJECT]', '[INCIDENT]', '[SUBSCRIPTION]');
     *     $incidentServiceClient->deleteSubscription($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the subscription.
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
    public function deleteSubscription($name, array $optionalArgs = [])
    {
        $request = new DeleteSubscriptionRequest();
        $request->setName($name);

        return $this->startCall(
            'DeleteSubscription',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a role assignment on an existing incident. Normally, the user field
     * will be set when assigning a role to oneself, and the next field will be
     * set when proposing another user as the assignee. Setting the next field
     * directly to a user other than oneself is equivalent to proposing and
     * force-assigning the role to the user.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     $incidentRoleAssignment = new IncidentRoleAssignment();
     *     $response = $incidentServiceClient->createIncidentRoleAssignment($formattedParent, $incidentRoleAssignment);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string                 $parent                 Resource name of the incident, e.g.
     *                                                       "projects/{project_id}/incidents/{incident_id}".
     * @param IncidentRoleAssignment $incidentRoleAssignment Role assignment to create.
     * @param array                  $optionalArgs           {
     *                                                       Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createIncidentRoleAssignment($parent, $incidentRoleAssignment, array $optionalArgs = [])
    {
        $request = new CreateIncidentRoleAssignmentRequest();
        $request->setParent($parent);
        $request->setIncidentRoleAssignment($incidentRoleAssignment);

        return $this->startCall(
            'CreateIncidentRoleAssignment',
            IncidentRoleAssignment::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an existing role assignment.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->roleAssignmentName('[PROJECT]', '[INCIDENT]', '[ROLE_ASSIGNMENT]');
     *     $incidentServiceClient->deleteIncidentRoleAssignment($formattedName);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the role assignment.
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
    public function deleteIncidentRoleAssignment($name, array $optionalArgs = [])
    {
        $request = new DeleteIncidentRoleAssignmentRequest();
        $request->setName($name);

        return $this->startCall(
            'DeleteIncidentRoleAssignment',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists role assignments that are part of an incident.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedParent = $incidentServiceClient->incidentName('[PROJECT]', '[INCIDENT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $incidentServiceClient->listIncidentRoleAssignments($formattedParent);
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
     *     $pagedResponse = $incidentServiceClient->listIncidentRoleAssignments($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Resource name of the incident, e.g.
     *                             "projects/{project_id}/incidents/{incident_id}".
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
    public function listIncidentRoleAssignments($parent, array $optionalArgs = [])
    {
        $request = new ListIncidentRoleAssignmentsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListIncidentRoleAssignments',
            $optionalArgs,
            ListIncidentRoleAssignmentsResponse::class,
            $request
        );
    }

    /**
     * Starts a role handover. The proposed assignee will receive an email
     * notifying them of the assignment. This will fail if a role handover is
     * already pending.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->roleAssignmentName('[PROJECT]', '[INCIDENT]', '[ROLE_ASSIGNMENT]');
     *     $newAssignee = new User();
     *     $response = $incidentServiceClient->requestIncidentRoleHandover($formattedName, $newAssignee);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the role assignment.
     * @param User   $newAssignee  The proposed assignee.
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
     * @return \Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function requestIncidentRoleHandover($name, $newAssignee, array $optionalArgs = [])
    {
        $request = new RequestIncidentRoleHandoverRequest();
        $request->setName($name);
        $request->setNewAssignee($newAssignee);

        return $this->startCall(
            'RequestIncidentRoleHandover',
            IncidentRoleAssignment::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Confirms a role handover. This will fail if the 'proposed_assignee' field
     * of the IncidentRoleAssignment is not equal to the 'new_assignee' field of
     * the request. If the caller is not the new_assignee,
     * ForceIncidentRoleHandover should be used instead.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->roleAssignmentName('[PROJECT]', '[INCIDENT]', '[ROLE_ASSIGNMENT]');
     *     $newAssignee = new User();
     *     $response = $incidentServiceClient->confirmIncidentRoleHandover($formattedName, $newAssignee);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the role assignment.
     * @param User   $newAssignee  The proposed assignee, who will now be the assignee. This should be the
     *                             current user; otherwise ForceRoleHandover should be called.
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
     * @return \Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function confirmIncidentRoleHandover($name, $newAssignee, array $optionalArgs = [])
    {
        $request = new ConfirmIncidentRoleHandoverRequest();
        $request->setName($name);
        $request->setNewAssignee($newAssignee);

        return $this->startCall(
            'ConfirmIncidentRoleHandover',
            IncidentRoleAssignment::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Forces a role handover. This will fail if the 'proposed_assignee' field of
     * the IncidentRoleAssignment is not equal to the 'new_assignee' field of the
     * request. If the caller is the new_assignee, ConfirmIncidentRoleHandover
     * should be used instead.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->roleAssignmentName('[PROJECT]', '[INCIDENT]', '[ROLE_ASSIGNMENT]');
     *     $newAssignee = new User();
     *     $response = $incidentServiceClient->forceIncidentRoleHandover($formattedName, $newAssignee);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the role assignment.
     * @param User   $newAssignee  The proposed assignee, who will now be the assignee. This should not be
     *                             the current user; otherwise ConfirmRoleHandover should be called.
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
     * @return \Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function forceIncidentRoleHandover($name, $newAssignee, array $optionalArgs = [])
    {
        $request = new ForceIncidentRoleHandoverRequest();
        $request->setName($name);
        $request->setNewAssignee($newAssignee);

        return $this->startCall(
            'ForceIncidentRoleHandover',
            IncidentRoleAssignment::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Cancels a role handover. This will fail if the 'proposed_assignee' field of
     * the IncidentRoleAssignment is not equal to the 'new_assignee' field of the
     * request.
     *
     * Sample code:
     * ```
     * $incidentServiceClient = new IncidentServiceClient();
     * try {
     *     $formattedName = $incidentServiceClient->roleAssignmentName('[PROJECT]', '[INCIDENT]', '[ROLE_ASSIGNMENT]');
     *     $newAssignee = new User();
     *     $response = $incidentServiceClient->cancelIncidentRoleHandover($formattedName, $newAssignee);
     * } finally {
     *     $incidentServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Resource name of the role assignment.
     * @param User   $newAssignee  Person who was proposed as the next assignee (i.e.
     *                             IncidentRoleAssignment.proposed_assignee) and whose proposal is being
     *                             cancelled.
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
     * @return \Google\Cloud\Irm\V1alpha2\IncidentRoleAssignment
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function cancelIncidentRoleHandover($name, $newAssignee, array $optionalArgs = [])
    {
        $request = new CancelIncidentRoleHandoverRequest();
        $request->setName($name);
        $request->setNewAssignee($newAssignee);

        return $this->startCall(
            'CancelIncidentRoleHandover',
            IncidentRoleAssignment::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
