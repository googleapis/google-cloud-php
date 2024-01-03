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

/**
 * @internal
 * Responsible for forwarding the requests to their
 * respective GAPIC methdos via the request wrapper.
 */
class RequestHandler
{
    use EmulatorTrait;
    use ArrayTrait;
    use TimeTrait;
    use WhitelistTrait;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @var GapicRequestWrapper Wrapper used to handle sending requests to the
     * gRPC/REST API.
     */
    private GapicRequestWrapper $requestWrapper;

    private array $gapics;

    /**
     * @param Serializer $serializer
     * @param array $gapicClasses
     * @param array $clientConfig
     * @param ?GapicRequestWrapper $requestWrapper
     */
    public function __construct(
        Serializer $serializer,
        array $gapicClasses,
        array $clientConfig = [],
        GapicRequestWrapper $requestWrapper = null,
    ) {
        //@codeCoverageIgnoreStart
        $this->serializer = $serializer;
        $clientConfig['serializer'] = $serializer;

        $this->requestWrapper = $requestWrapper ?? new GapicRequestWrapper($serializer);

        // Adds some defaults
        // gccl needs to be present for handwritten clients
        $clientConfig += [
            'libName' => 'gccl',
            'transport' => $this->getDefaultTransport(),
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
        
        // Initialize the Gapic classes and store them in memory
        $this->gapics = [];
        foreach ($gapicClasses as $cls) {
            $this->gapics[$cls] = new $cls($clientConfig);
        }
    }

    /**
     * Helper function that forwards the request to a gapic client obj.
     *
     * @param $gapicClass The request will be forwarded to this GAPIC class.
     * @param $method This method needs to be called on the gapic obj.
     * @param $requiredArgs The positional arguments to be passed on the $method
     * @param $args The optional args.
     * 
     * @return \Generator|OperationResponse|array|null
     * 
     * @throws ServiceException
     *
     * If a GAPIC class is provided as the first argument,
     * then the GAPIC object already stored in memory is used.
     * If a GAPIC object is supplied,then we use the object as is.
     * This is useful to override the GAPIC object used for one specific request.
     */
    public function sendRequest(
        string $gapicClass,
        string $method,
        array $requiredArgs,
        array $optionalArgs,
        bool $whitelisted = false
    ) {

        $allArgs = $requiredArgs;

        // we send the optional args in the end, because everything before that is
        // passed on the the `$method` as a positional argument
        $allArgs[] = $optionalArgs;

        $gapicObj = $this->getGapicObject($gapicClass);

        if (!$gapicObj) {
            return null;
        }

        try {
            return $this->requestWrapper->send([$gapicObj, $method], $allArgs);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }

    /**
     * Returns the current serializer instance.
     *
     * @return Serializer
     */
    public function getSerializer() : Serializer
    {
        return $this->serializer;
    }

    /**
     * Helper function that returns a GAPIC object stored in memory
     * using the GAPIC class as key.
     * Alternatively, if a GAPIC object is supplied, then that object is returned
     * as is.
     * @param $gapicClass The GAPIC class whose object we need.
     * @return mixed
     */
    private function getGapicObject(string $gapicClass)
    {
        return $this->gapics[$gapicClass] ?? null;
    }

    private function getDefaultTransport() : string
    {
        $isGrpcExtensionLoaded = $this->isGrpcLoaded();
        $defaultTransport = $isGrpcExtensionLoaded ? 'grpc' : 'rest';
        return $defaultTransport;
    }

    protected function isGrpcLoaded() : bool
    {
        return extension_loaded('grpc');
    }
}
