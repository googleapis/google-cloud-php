<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud;

use Google\Cloud\GrpcRequestWrapper;

/**
 * Provides shared functionality for gRPC service implementations.
 */
trait GrpcTrait
{
    /**
     * @var GrpcRequestWrapper Wrapper used to handle sending requests to the
     * gRPC API.
     */
    private $requestWrapper;

    /**
     * Sets the request wrapper.
     *
     * @param GrpcRequestWrapper $requestWrapper
     */
    public function setRequestWrapper(GrpcRequestWrapper $requestWrapper)
    {
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * Delivers a request.
     *
     * @param callable $request
     * @param array $args
     * @return array
     */
    public function send(callable $request, array $args)
    {
        $requestOptions = $args[count($args) - 1];

        return $this->requestWrapper->send($request, $args, array_intersect_key($requestOptions, [
            'grpcOptions' => null,
            'retries' => null
        ]));
    }

    /**
     * Pluck a value out of an array.
     *
     * @param string $name
     * @param array $args
     * @return string
     */
    public function pluck($name, array &$args)
    {
        $value = $args[$name];
        unset($args[$name]);
        return $value;
    }
}
