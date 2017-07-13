<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace\Integrations;

use Doctrine\ORM\Version;
use Doctrine\ORM\AbstractQuery;
use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Driver\PDOStatement;

/**
 * This class handles instrumenting the Doctrine ORM queries using the stackdriver_trace extension.
 *
 * Example:
 * ```
 * use Google\Cloud\Trace\Integrations\Doctrine
 *
 * Doctrine::load();
 */
class Doctrine implements IntegrationInterface
{
    /**
     * Static method to add instrumentation to the Symfony framework
     */
    public static function load()
    {
        if (!extension_loaded('stackdriver_trace')) {
            return;
        }

        $persisterClass = (Version::compare('2.5.0') < 0)
            ? 'Doctrine\ORM\Persisters\Entity\BasicEntityPersister'    // Doctrine 2.5 or greater
            : 'Doctrine\ORM\Persisters\BasicEntityPersister';          // Doctrine 2.4 or earlier

        // public function load(array $criteria, $entity = null, $assoc = null, array $hints = array(),
        //      $lockMode = null, $limit = null, array $orderBy = null)
        stackdriver_trace_method($persisterClass, 'load', function ($bep) {
            return [
                'name' => 'doctrine/load',
                'labels' => ['entity' => $bep->getClassMetadata()->name]
            ];
        });

        // public function loadAll(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
        stackdriver_trace_method($persisterClass, 'loadAll', function ($bep) {
            return [
                'name' => 'doctrine/loadAll',
                'labels' => ['entity' => $bep->getClassMetadata()->name]
            ];
        });

        // public int PDOConnection::exec(string $query)
        stackdriver_trace_method(PDOConnection::class, 'exec', function ($scope, $query) {
            return [
                'name' => 'doctrine/exec',
                'labels' => ['query' => $query]
            ];
        });

        // public PDOStatement PDOConnection::query(string $query)
        // public PDOStatement PDOConnection::query(string $query, int PDO::FETCH_COLUMN, int $colno)
        // public PDOStatement PDOConnection::query(string $query, int PDO::FETCH_CLASS, string $classname, array $ctorargs)
        // public PDOStatement PDOConnection::query(string $query, int PDO::FETCH_INFO, object $object)
        stackdriver_trace_method(PDOConnection::class, 'query', function ($scope, $query) {
            return [
                'name' => 'doctrine/query',
                'labels' => ['query' => $query ? $query : 'unknown']
            ];
        });

        // public bool PDOConnection::commit ( void )
        stackdriver_trace_method(PDOConnection::class, 'commit');

        // public PDOConnection::__construct(string $dsn [, string $username [, string $password [, array $options]]])
        stackdriver_trace_method(PDOConnection::class, '__construct', function ($scope, $dsn) {
            return [
                'name' => 'doctrine/connect',
                'labels' => ['dsn' => $dsn ? $dsn : 'unknown']
            ];

        });

        // public bool PDOStatement::execute([array $params])
        stackdriver_trace_method(PDOStatement::class, 'execute', function ($scope) {
            return [
                'name' => 'doctrine/statement/execute',
                'labels' => ['query' => $scope->queryString]
            ];
        });
    }
}
