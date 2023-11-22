<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\WhitelistTrait;

/**
 * Provides shared functionality for making requests to GAPIC clients
 * agnostic of the protocol.
 */
trait RequestCallerTrait
{
    use ArrayTrait;
    use TimeTrait;
    use WhitelistTrait;

    /**
     * @var GapicRequestWrapper Wrapper used to handle sending requests to the
     * gRPC/REST API.
     */
    private $requestWrapper;

    /**
     * Sets the request wrapper.
     *
     * @param GapicRequestWrapper $requestWrapper
     */
    public function setRequestWrapper(GapicRequestWrapper $requestWrapper)
    {
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * Get the RequestWrapper.
     *
     * @return GapicRequestWrapper|null
     */
    public function requestWrapper()
    {
        return $this->requestWrapper;
    }

    /**
     * Delivers a request.
     *
     * @param callable $request
     * @param array $args
     * @param bool $whitelisted
     * @return \Generator|array
     * @throws ServiceException
     */
    public function send(callable $request, array $args, $whitelisted = false)
    {
        $requestOptions = $this->pluckArray([
            'requestOptions'
        ], $args[count($args) - 1]);

        try {
            return $this->requestWrapper->send($request, $args, $requestOptions);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }
}
