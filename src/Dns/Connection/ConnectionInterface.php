<?php
/**
 * Created by PhpStorm.
 * User: Adhi
 * Date: 9/11/2016
 * Time: 10:57 AM
 */

namespace Google\Cloud\Dns\Connection;


interface ConnectionInterface
{
    /**
     * @param array $args
     */
    public function createChanges(array $args = []);

    /**
     * @param array $args
     */
    public function getChanges(array $args = []);

    /**
     * @param array $args
     */
    public function listChanges(array $args = []);

    /**
     * @param array $args
     */
    public function createManagedZones(array $args = []);

    /**
     * @param array $args
     */
    public function deleteManagedZones(array $args = []);

    /**
     * @param array $args
     */
    public function getManagedZones(array $args = []);

    /**
     * @param array $args
     */
    public function listManagedZones(array $args = []);

    /**
     * @param array $args
     */
    public function getProject(array $args = []);

    /**
     * @param array $args
     */
    public function listResourceRecordSets(array $args = []);
}