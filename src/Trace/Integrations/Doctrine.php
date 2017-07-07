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

        $persisterClass = (Version::compare(2.5.0) < 1)
            ? 'Doctrine\ORM\Persisters\BasicEntityPersister'            // Doctrine 2.4 or earlier
            : 'Doctrine\ORM\Persisters\Entity\BasicEntityPersister';    // Doctrine 2.5 or greater

        $withCriteria = function ($scope, $criteria, $entity) {
            return [
                'labels' => ['entity' => get_class($entity)]
            ];
        };
        stackdriver_trace_method($persisterClass, 'load', $withCriteria);
        stackdriver_trace_method($persisterClass, 'loadAll', $withCriteria);
        stackdriver_trace_method(AbstractQuery::class, 'execute');
    }
}
