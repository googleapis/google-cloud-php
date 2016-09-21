<?php

namespace Google\Cloud\Dns;

use Google\Cloud\ClientTrait;
use Google\Cloud\Dns\Connection\ConnectionInterface;
use Google\Cloud\Dns\Connection\Rest;


/**
 * Google Cloud Dns client. Allows you to store and retrieve dns information on
 * Google's infrastructure. Find more information at
 * [Google Cloud Dns API docs](https://cloud.google.com/dns/docs/).
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $dns = $cloud->dns();
 * ```
 *
 * ```
 * // StorageClient can be instantiated directly.
 * use Google\Cloud\Dns\DnsClient;
 *
 * $dns = new DnsClient();
 * ```
 */
class DnsClient
{

    use ClientTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/cloud-platform';
    const READ_ONLY_SCOPE = 'https://www.googleapis.com/auth/ndev.clouddns.readonly';
    const READ_WRITE_SCOPE = 'https://www.googleapis.com/auth/ndev.clouddns.readwrite';

    /**
     * @var ConnectionInterface $connection Represents a connection to Dns.
     */
    protected $connection;

    /**
     * Create a Dns client.
     *
     * @param array $config {
     *     Configuration options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Lazily instantiates a managed zone. There are no network requests made at this
     * point. To see the operations that can be performed on a managed zone please
     * see {@see Google\Cloud\Dns\ManagedZone}.
     *
     * Example:
     * ```
     * $storage->managedZone('myManagedZone');
     * ```
     *
     * @param string $name The name of the bucket to request.
     * @return ManagedZone
     */
    public function managedZone($name)
    {
        return new ManagedZone($this->connection, $name);
    }

    /**
     * Fetches all managed zones in the project.
     *
     * Example:
     * ```
     * $managedZones = $dns->managedZones();
     * ```
     *
     * ```
     *
     * foreach ($managedZones as $managedZone) {
     *     var_dump($managedZone);
     * }
     * ```
     *
     * @see https://cloud.google.com/storage/docs/json_api/v1/buckets/list Buckets list API documentation.
     *
     * @param array $options {
     *     Configuration options.
     *
     *     @type integer $maxResults Maximum number of results to return per
     *           request.
     *     @type string $prefix Filter results with this prefix.
     *     @type string $projection Determines which properties to return. May
     *           be either 'full' or 'noAcl'.
     *     @type string $fields Selector which will cause the response to only
     *           return the specified fields.
     * }
     * @return \Generator<Google\Cloud\Storage\ManagedZone>
     */
    public function managedZones(array $options = [])
    {
        $options['pageToken'] = null;

        do {
            $response = $this->connection->listManagedZones($options + ['project' => $this->projectId]);

            foreach ($response['items'] as $managedZone) {
                yield new ManagedZone($this->connection, $managedZone['name'], $managedZone);
            }

            $options['pageToken'] = isset($response['nextPageToken']) ? $response['nextPageToken'] : null;
        } while ($options['pageToken']);
    }

    

}