<?php

namespace Google\Cloud\Dns\Connection;

use Google\Cloud\RequestBuilder;
use Google\Cloud\RequestWrapper;
use Google\Cloud\RestTrait;
use Google\Cloud\UriTrait;

class Rest implements ConnectionInterface
{

    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://www.googleapis.com/dns/v1/projects/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            __DIR__ . '/ServiceDefinition/dns-v1.json',
            self::BASE_URI
        ));
    }

    /**
     * @param array $args
     */
    public function createChanges(array $args = [])
    {
        return $this->send('changes', 'create', $args);
    }

    /**
     * @param array $args
     */
    public function getChanges(array $args = [])
    {
        return $this->send('changes', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listChanges(array $args = [])
    {
        return $this->send('changes', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function createManagedZones(array $args = [])
    {
        return $this->send('managedZones', 'create', $args);
    }

    /**
     * @param array $args
     */
    public function deleteManagedZones(array $args = [])
    {
        return $this->send('managedZones', 'delete', $args);
    }

    /**
     * @param array $args
     */
    public function getManagedZones(array $args = [])
    {
        return $this->send('managedZones', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listManagedZones(array $args = [])
    {
        return $this->send('managedZones', 'list', $args);
    }

    /**
     * @param array $args
     */
    public function getProject(array $args = [])
    {
        return $this->send('projects', 'get', $args);
    }

    /**
     * @param array $args
     */
    public function listResourceRecordSets(array $args = [])
    {
        return $this->send('resourceRecordSets', 'list', $args);
    }
}