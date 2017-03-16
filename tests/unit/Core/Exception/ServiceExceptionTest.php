<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Unit\Core\Exception;

use Google\Cloud\Core\Exception\ServiceException;

/**
 * @group core
 * @group exception
 */
class ServiceExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasServiceException()
    {
        $previous = new \Exception('test');

        $ex = new ServiceException('foo', 123, $previous);
        $this->assertTrue($ex->hasServiceException());

        $this->assertEquals($previous, $ex->getServiceException());
    }

    public function testDoesntHaveServiceException()
    {
        $ex = new ServiceException('foo');
        $this->assertFalse($ex->hasServiceException());
    }
}
