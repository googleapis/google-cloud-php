<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Spanner\Operation;

/**
 * Refresh Spanner operation class
 */
trait OperationRefreshTrait
{
    /**
     * Refresh the operation property of a given stubbed class.
     *
     * @param mixed $stub
     * @param RequestHandler $requestHandler
     * @param Serializer $serializer
     * @param bool $returnInt64AsObject
     * @return mixed
     */
    public function refreshOperation(
        $stub,
        RequestHandler $requestHandler,
        Serializer $serializer,
        bool $returnInt64AsObject = false
    ) {
        $stub->___setProperty(
            'operation',
            new Operation($requestHandler, $serializer, $returnInt64AsObject)
        );
        return $stub;
    }
}
