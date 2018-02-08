<?php
namespace Google\Cloud\Bigtable\src;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Protobuf\Internal\MapField;
use Google\Cloud\Protobuf\Internal\GPBType;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type;

/**
*
*/
class BigtableInstance
{
    private $InstanceAdmin;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->InstanceAdmin = new BigtableInstanceAdminClient();
    }
    
    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $projectId
     *
     * @return string The formatted project resource.
     */
    public function projectName($projectId)
    {
        $formattedParent = BigtableInstanceAdminClient::projectName($projectId);
        return $formattedParent;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance resource.
     *
     * @param string $projectId
     *
     * @param string $instanceId
     *
     * @return string The formatted instance resource.
     */
    public function instanceName($projectId, $instanceId)
    {
        $formattedParent = BigtableInstanceAdminClient::instanceName($projectId, $instanceId);
        return $formattedParent;
    }

    /**
     * Create an instance within a project.
     *
     * @param string   $parent       The unique name of the project in which to create the new instance.
     *                               Values are of the form `projects/<project>`.
     *
     * @param string   $instanceId   The ID to be used when referring to the new instance within its project,
     *                               e.g., just `myinstance` rather than
     *                               `projects/myproject/instances/myinstance`.
     *
     * @param string   $location     values should be of the form
     *                               `projects/<project>/locations/<zone>`.
     *
     * @param string   $clusterId    cluseter id
     *
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\GAX\OperationResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function createInstance($parent, $instanceId, $location, $clusterId, $optionalArgs = [])
    {
        $instance = new Instance();
        $instance->setDisplayName($instanceId);
        $instance->setType(2);

        $clusters = new Cluster();
        $clusters->setName($clusterId);
        $clusters->setDefaultStorageType(2);
        $clusters->setLocation($location);
        $MapField = new MapField(GPBType::STRING, GPBType::MESSAGE, Cluster::class);
        $MapField[$clusterId] = $clusters;

        $Instance = $this->InstanceAdmin->createInstance($parent, $instanceId, $instance, $MapField, $optionalArgs);
        return $Instance;
    }

    /**
     * Updates an instance within a project.
     *
     *
     * @param string $name         (`OutputOnly`)
     *                             The unique name of the instance. Values are of the form
     *                             `projects/<project>/instances/[a-z][a-z0-9\\-]+[a-z0-9]`.
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Can be changed at any time, but should be kept globally unique
     *                             to avoid confusion.
     * @param int    $type         The type of the instance. Defaults to `PRODUCTION`.
     *                             For allowed values, use constants defined on
     *                             {@see \Google\Bigtable\Admin\V2\Instance_Type}
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the instance.
     *          For allowed values, use constants defined on {@see \Google\Bigtable\Admin\V2\Instance_State}
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\Admin\V2\Instance
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateInstance($name, $displayName, $type, $optionalArgs = [])
    {
        $Instance = $this->InstanceAdmin->updateInstance($name, $displayName, $type, $optionalArgs = []);
        return $Instance;
    }

    /**
     * Lists information about instances in a project.
     *
     * @param string $parent       The unique name of the project for which a list of instances is requested.
     *                             Values are of the form `projects/<project>`.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          The value of `next_page_token` returned by a previous call.
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\Admin\V2\ListInstancesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
    */
    public function listInstances($parent, $optionalArgs = [])
    {
        $ListInstances = $this->InstanceAdmin->listInstances($parent, $optionalArgs);
        return $ListInstances;
    }

    /**
     * Delete an instance from a project.
     *
     * @param string $formattedParent    The unique name of the instance to be deleted.
     *                                   Values are of the form `projects/<project>/instances/<instance>`.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Protobuf\GPBEmpty
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function deleteInstance($formattedParent, $optionalArgs = [])
    {
        $response = $this->InstanceAdmin->deleteInstance($formattedParent, $optionalArgs);
        return $response;
    }
}
