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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\WhitelistTrait;
use \Google\Protobuf\Internal\Message;
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;

/**
 * @internal
 * Responsible for forwarding the requests to their
 * respective client methdos via the request wrapper.
 */
class RequestHandler
{
    use EmulatorTrait;
    use ArrayTrait;
    use TimeTrait;
    use WhitelistTrait;
    use RequestProcessorTrait;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    private array $clients;

    /**
     * @param Serializer $serializer
     * @param array $clientClasses
     * @param array $clientConfig
     */
    public function __construct(
        Serializer $serializer,
        array $clientClasses,
        array $clientConfig = []
    ) {
        //@codeCoverageIgnoreStart
        $this->serializer = $serializer;
        $clientConfig['serializer'] = $serializer;

        // Adds some defaults
        // gccl needs to be present for handwritten clients
        $clientConfig += [
            'libName' => 'gccl',
            'emulatorHost' => null
        ];

        if ((bool) $clientConfig['emulatorHost']) {
            $emulatorConfig = $this->emulatorGapicConfig($clientConfig['emulatorHost']);
            $clientConfig = array_merge(
                $clientConfig,
                $emulatorConfig
            );
        }
        //@codeCoverageIgnoreEnd
        
        // Initialize the client classes and store them in memory
        $this->clients = [];
        foreach ($clientClasses as $className) {
            $this->clients[$className] = new $className($clientConfig);
        }
    }

    /**
     * Helper function that forwards the request to a client obj.
     *
     * @param string $clientClass The request will be forwarded to this client class.
     * @param string $method This method needs to be called on the client obj.
     * @param Message $request The protobuf Request instance to pass as the first argument to the $method.
     * @param array $optionalArgs The optional args.
     * @param bool $whitelisted This decides the behaviour when a NotFoundException is encountered.
     *
     * @return \Generator|OperationResponse|array|null
     *
     * @throws ServiceException
     */
    public function sendRequest(
        string $clientClass,
        string $method,
        Message $request,
        array $optionalArgs,
        bool $whitelisted = false
    ) {
        $clientObj = $this->getClientObject($clientClass);

        if (!$clientObj) {
            return null;
        }

        $allArgs = [$request];
        $allArgs[] = $optionalArgs;

        try {
            $callable = [$clientObj, $method];
            $response = call_user_func_array($callable, $allArgs);

            return $this->handleResponse($response);
        } catch (ApiException $ex) {
            throw $this->convertToGoogleException($ex);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }

    /**
     * Helper function that returns a client object stored in memory
     * using the client class as key.
     * @param $clientClass The client class whose object we need.
     * @return mixed
     */
    private function getClientObject(string $clientClass)
    {
        return $this->clients[$clientClass] ?? null;
    }
}
